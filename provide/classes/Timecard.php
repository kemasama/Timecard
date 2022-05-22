<?php

class Timecard
{
    public function __construct($pdo)
    {
        $this->pdo = $pdo;
    }

    protected $pdo;

    public function InsertTime()
    {
    }
}
