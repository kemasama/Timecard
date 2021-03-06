<?php
/***
 * Copyright (c) 2022 DevRas
 * 
 */

 class User
{
    public function __construct($pdo)
    {
        $this->pdo = $pdo;
    }
    
    protected $pdo;

    public function formalPassword($password)
    {
        return hash("sha256", $password);
    }

    public function hasLogout()
    {
        $filter = filter_input(INPUT_GET, "logout");
        if ($filter)
        {
            return true;
        } else {
            return false;
        }
    }

    public function hasLogin()
    {
        $username = filter_input(INPUT_POST, "username");
        $password = filter_input(INPUT_POST, "password");

        if (!$username || !$password)
        {
            return false;
        }

        $result = $this->Login($username, $password);

        return $result;
    }

    public function hasUpdatePassword()
    {
        $username = filter_input(INPUT_POST, "username");
        $password = filter_input(INPUT_POST, "password");
        $newPassword = filter_input(INPUT_POST, "newPassword");

        if (!$username || !$password || !$newPassword)
        {
            return false;
        }

        $currentUser = $this->Login($username, $password);
        if (!$currentUser)
        {
            return false;
        }

        $result = $this->updatePassword($currentUser, $newPassword);

        return $result;
    }

    public function hasCreate()
    {
        $username = filter_input(INPUT_POST, "username");
        $password = filter_input(INPUT_POST, "password");
        $mode = filter_input(INPUT_POST, "mode");

        if (!$username || !$password || !$mode)
        {
            return false;
        }

        $result = $this->Create($username, $password);

        return $result;
    }

    public function updatePassword($currentUser, $newPassword)
    {
        try {
            $formal = $this->formalPassword($newPassword);

            $smt = $this->pdo->prepare("UPDATE users SET password=? WHERE id=?");
            $smt->execute([
                $formal,
                $currentUser["id"]
            ]);

            return true;
        } catch (\PDOException $e)
        {
            throw new \RuntimeException("SQL?????????????????????????????????????????????????????????????????????????????????");
        }
    }

    public function Login($username, $password)
    {
        try {
            $formal = $this->formalPassword($password);

            $smt = $this->pdo->prepare("SELECT * FROM users WHERE username=? AND password=?;");
            $smt->execute([
                $username,
                $formal
            ]);

            return $smt->fetch();
        } catch (\PDOException $e)
        {
            throw new \RuntimeException("SQL????????????????????????????????????????????????UserLogin");
        }
    }

    public function Create($username, $password)
    {
        $user = $this->getUser($username);
        if ($user)
        {
            throw new \RuntimeException("?????????????????????????????????????????????????????????????????????????????????");
        }

        try {
            $smt = $this->pdo->prepare("INSERT INTO users(username, password) VALUES(?, ?);");
            $formal = $this->formalPassword($password);

            $smt->execute([
                $username,
                $formal
            ]);

            return true;
        } catch (\PDOException $e)
        {
            throw new \RuntimeException("SQL????????????????????????????????????????????????createUser");
        }
    }

    public function getUser($username)
    {
        try {
            $smt = $this->pdo->prepare("SELECT * FROM users WHERE username=?");

            $smt->execute([
                $username
            ]);

            return $smt->fetch();
        } catch (\PDOException $e)
        {
            throw new \RuntimeException("SQL????????????????????????????????????????????????getUser");
        }
    }

    public function getUserById($id)
    {
        try {
            $smt = $this->pdo->prepare("SELECT * FROM users WHERE id=?");

            $smt->execute([
                $id
            ]);

            return $smt->fetch();
        } catch (\PDOException $e)
        {
            throw new \RuntimeException("SQL????????????????????????????????????????????????getUser");
        }
    }
}
