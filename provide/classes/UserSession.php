<?php
/***
 * Copyright (c) 2022 DevRas
 * 
 */

class UserSession
{
    public function __construct()
    {
        @session_start();
    }

    public $SessionName = "devras_timecard";

    public function isLogged()
    {
        if (!isset($_SESSION[$this->SessionName]))
        {
            return false;
        }

        return !empty($_SESSION[$this->SessionName]);
    }

    public function getUsername()
    {
        return $_SESSION[$this->SessionName];
    }

    public function setUsername($value)
    {
        $_SESSION[$this->SessionName] = $value;
    }
}
