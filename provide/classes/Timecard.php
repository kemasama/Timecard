<?php
/***
 * Copyright (c) 2022 DevRas
 * 
 */

class Timecard
{
    public function __construct($pdo)
    {
        $this->pdo = $pdo;
    }

    protected $pdo;
    public $queryTime = [];

    public function InitTables()
    {
        try {
            $pdo = $this->pdo;

            $pdo->query("CREATE TABLE IF NOT EXISTS users(id INT NOT NULL AUTO_INCREMENT PRIMARY KEY, username VARCHAR(50) NOT NULL, password VARCHAR(64) NOT NULL, created_at DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP);");
            $pdo->query("CREATE TABLE IF NOT EXISTS cards(id INT NOT NULL AUTO_INCREMENT PRIMARY KEY, uid INT NOT NULL, startTime DATETIME, endTime DATETIME, validate INT NOT NULL DEFAULT 0);");
        } catch (\PDOException $e)
        {
            throw new \RuntimeException("データベースの初期化中にエラーが発生しました。");
        }
    }

    public function getUsers()
    {
        try {
            $smt = $this->pdo->prepare("SELECT * FROM users");
            $smt->execute([
            ]);

            $buf = array();
            while ( $row = $smt->fetch() )
            {
                $buf[] = array(
                    "id" => $row["id"],
                    "username" => $row["username"],
                    "created_at" => $row["created_at"],
                );
            }

            return $buf;
        } catch (\PDOException $e)
        {
            throw new \RuntimeException("SQLエラーが発生しました。発生箇所：getUsers");
        }
    }

    public function hasCard($id, $admin)
    {
        $uid = filter_input(INPUT_POST, "uid");
        $mode = filter_input(INPUT_POST, "reg");
        $date = filter_input(INPUT_POST, "date");

        if (!$uid || !$mode)
        {
            return false;
        }

        if ($uid < 0)
        {
            return false;
        }

        if (!$admin && $id != $uid)
        {
            return false;
        }

        if (!$admin)
        {
            $date = "";
        }

        switch ($mode)
        {
            case "auto":
                $this->InsertTime($uid, $date);
                break;
            case "start":
                $this->InsertTimeManual(CardType::START, $uid, $date);
                break;
            case "end":
                $this->InsertTimeManual(CardType::END, $uid, $date);
                break;
            default:
                break;
        }

        return true;
    }

    public function SelectTimes($uid, $month = 0)
    {
        try {
            $mm = strtotime(sprintf("%dmonth", $month));
            $today = ((int) date("d")) - 1;
            $dayCount = (int) date("t");

            if ( $month == 0 )
            {
                $startTime = date("Y-m-d 00:00:00", strtotime(sprintf("-%ddays", $today)));
                $endTime = date("Y-m-d 00:00:00", strtotime(sprintf("+%ddays", $dayCount - $today)));
            } else {
                $y = date("Y", $mm);
                $m = date("m", $mm);
                $ly = $y;
                $lm = $m + 1;
                if ($lm > 12)
                {
                    $ly += 1;
                    $lm = 1;
                }

                $startTime = date("Y-m-d 00:00:00", strtotime(sprintf("%d-%d-01", $y, $m)));
                $endTime = date("Y-m-d 00:00:00", strtotime(sprintf("%d-%d-01", $ly, $lm)));
            }


            $this->queryTime = [$startTime, $endTime];

            $smt = $this->pdo->prepare("SELECT * FROM cards WHERE startTime > ? AND startTime < ? AND uid=?;");
            $smt->execute([
                $startTime,
                $endTime,
                $uid
            ]);
            
            $buf = array();

            while ($row = $smt->fetch())
            {
                $start = strtotime($row["startTime"]);
                $end = strtotime($row["endTime"]);

                $diff = $end - $start;
                $workTime = $diff / 60 / 60;
                $workHour = floor($workTime);
                $workMinutes = floor(($workTime - $workHour) * 60);

                $buf[] = array(
                    "startTime" => $row["startTime"],
                    "endTime" => $row["endTime"],
                    "validate" => $row["validate"],
                    "id" => $row["id"],
                    "workTime" => $workTime,
                    "workHour" => $workHour,
                    "workMinutes" => $workMinutes,
                );
            }

            return $buf;
        } catch (\PDOException $e)
        {
            throw new \RuntimeException("SQLエラーが発生しました。発生箇所：selectTimes");
        }
    }

    public function InsertTime($uid, $date)
    {
        try {
            $smt;

            $lix = $this->getLastInsert($uid);
            $now = date("Y-m-d H:i:s");
            if (strtotime($date))
            {
                $now = date("Y-m-d H:i:s", strtotime($date));
            }

            if ( !$lix )
            {
                $smt = $this->pdo->prepare("INSERT INTO cards(uid, startTime) VALUES(?, ?);");
                $smt->execute([
                    $uid,
                    $now
                ]);
            } else if ( $lix )
            {
                $smt = $this->pdo->prepare("UPDATE cards SET endTime = ?, validate = 1 WHERE id = ?;");
                $smt->execute([
                    $now,
                    $lix["id"]
                ]);
            } else {
                throw new \RuntimeException("打刻できませんでした。原因：不明な操作");
            }

        } catch (\PDOException $e)
        {
            throw new \RuntimeException("SQLエラーが発生しました。発生箇所：insertTime");
        }
    }

    public function InsertTimeManual($type, $uid, $date)
    {
        try {
            $smt;

            $lix = $this->getLastInsert($uid);
            $now = date("Y-m-d H:i:s");
            if (strtotime($date))
            {
                $now = date("Y-m-d H:i:s", strtotime($date));
            }

            if ( !$lix && $type == CardType::START )
            {
                $smt = $this->pdo->prepare("INSERT INTO cards(uid, startTime) VALUES(?, ?);");
                $smt->execute([
                    $uid,
                    $now
                ]);
            } else if ( $lix && $type == CardType::END )
            {
                $smt = $this->pdo->prepare("UPDATE cards SET endTime = ?, validate = 1 WHERE id = ?;");
                $smt->execute([
                    $now,
                    $lix["id"]
                ]);
            } else {
                throw new \RuntimeException("打刻できませんでした。原因：始業が登録済みで始業をした。または、終業済みで終業をした。または、不明な操作。");
            }

        } catch (\PDOException $e)
        {
            throw new \RuntimeException("SQLエラーが発生しました。発生箇所：insertTime");
        }
    }

    public function getLastInsert($uid)
    {
        try {
            $smt = $this->pdo->prepare("SELECT * FROM cards WHERE uid = ? AND validate = 0 ORDER BY id DESC LIMIT 1;");

            $smt->execute([
                $uid
            ]);

            return $smt->fetch();
        } catch (\PDOException $e)
        {
            throw new \RuntimeException("SQLエラーが発生しました。発生箇所：lastInsert");
        }
    }
}
