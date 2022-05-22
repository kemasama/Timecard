<?php

class IDB {
    public function __construct() {
        $this->pdo = null;
    }

    private $pdo;

    public function Connect($host, $name, $user, $pass) {
        try {
            $this->pdo = new PDO("mysql:dbname=" . $name . ";host=" . $host, $user, $pass);
            return true;
        } catch (PDOException $e) {
            return false;
        }
    }

    public function getDB() {
        return $this->pdo;
    }
}

