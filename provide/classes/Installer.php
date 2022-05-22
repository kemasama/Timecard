<?php

class Installer
{
    public function __construct($file)
    {
        $this->filePath = $file;
    }

    protected $filePath;
    protected $fp;

    public function open()
    {
        $this->fp = fopen($this->filePath, "r+");

        return $this->fp;
    }

    public function close()
    {
        fclose($this->fp);
    }

    public function read()
    {
        return fgets($this->fp, 4096);
    }

    public function write($value)
    {
        fwrite($this->fp, $value);
    }

    protected $buffer = [];
    public function dumpBuffer()
    {
        return $this->buffer;
    }

    public function readToBuffer()
    {
        $line = false;
        while (($line = $this->read()) !== false) {
            $line = trim($line);
            array_push($this->buffer, $line);
        }
    }

    public function writeBuffer()
    {
        ftruncate($this->fp,0);
        fseek($this->fp, 0, SEEK_SET);
        for ($i = 0; $i < count($this->buffer); $i++)
        {
            $this->write($this->buffer[$i] . PHP_EOL);
        }
    }

    public function setKeyBuffer($key, $value, $formal = true)
    {
        $key = $this->format($key);
        if ($formal)
        {
            $value = $this->format($value);
        }

        for ($i = 0; $i < count($this->buffer); $i++)
        {
            $line = $this->buffer[$i];
            $line = trim($line);

            $args = explode("=>", $line);

            if (count($args) != 2)
            {
                continue;
            }

            $args[0] = trim($args[0]);
            $args[1] = trim($args[1]);

            if ($args[0] == $key)
            {
                $args[1] = $value;
                $newLine = $args[0] . " => " . $args[1];
                $last = mb_substr($line, -1);
                if ($last == ",")
                {
                    $newLine .= ",";
                }

                $this->buffer[$i] = $newLine;
                break;
            }
        }
    }

    public function rewrite($key, $value)
    {
        $line = false;
        $key = $this->format($key);
        $value = $this->format($value);
        $args = [$key, $value];

        $buffer = [];

        while (($line = $this->read()) !== false) {
            $line = trim($line);
            $args = explode("=>", $line);

            if (count($args) != 2)
            {
                array_push($buffer, $line);
                continue;
            }

            $args[0] = trim($args[0]);
            $args[1] = trim($args[1]);

            if ($args[0] == $key)
            {
                $args[1] = $value;
                $newLine = $args[0] . " => " . $args[1];
                $last = mb_substr($line, -1);
                if ($last == ",")
                {
                    $newLine .= ",";
                }
            } else {
                $newLine = $line;
            }

            echo $newLine . PHP_EOL;
            array_push($buffer, $newLine);
        }

        ftruncate($this->fp,0);
        fseek($this->fp, 0, SEEK_SET);
        for ($i = 0; $i < count($buffer); $i++)
        {
            $this->write($buffer[$i] . "\n");
        }
    }

    public function format($value)
    {
        return "\"" . $value . "\"";
    }
}
