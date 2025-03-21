<?php

class InputValidation
{

    public function validateInput($input)
    {
        // code to validate input
        return true;
    }

    public function validateEmail($email)
    {
        if (filter_var($email, FILTER_VALIDATE_EMAIL)) {
            return true;
        } else {
            return false;
        }
    }

    public function validatePassword($password)
    {
        if (preg_match('/^(?=.*[a-z])(?=.*[A-Z])(?=.*\d)[a-zA-Z\d]{8,}$/', $password)) {
            return true;
        } else {
            return false;
        }
    }

    public function validatePhone($phone)
    {
        if (preg_match('/^[0-9]{10}$/', $phone)) {
            return true;
        } else {
            return false;
        }
    }

    public function validateName($name)
    {
        if (preg_match('/^[a-zA-Z\s]+$/', $name)) {
            return true;
        } else {
            return false;
        }
    }

    public function validateDate($date)
    {
        if (preg_match('/^[0-9]{4}-[0-9]{2}-[0-9]{2}$/', $date)) {
            return true;
        } else {
            return false;
        }
    }
}
