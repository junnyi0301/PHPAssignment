<?php

class SessionManagement
{
    public function __construct()
    {
        session_start();
    }

    public function setSession($key, $value)
    {
        $_SESSION[$key] = $value;
    }

    public function getSession($key)
    {
        if (isset($_SESSION[$key])) {
            return $_SESSION[$key];
        } else {
            return null;
        }
    }

    public function endSession()
    {
        session_destroy();
    }

    public function clearSession()
    {
        session_unset();
    }

    public function unsetSession($key)
    {
        unset($_SESSION[$key]);
    }

    public function checkSession()
    {
        if (isset($_SESSION['user_id'])) {
            return true;
        } else {
            return false;
        }
    }
}
