<?php

require_once("DatabaseManagement.php");

use AngryBytes\Hash\Hash;
use AngryBytes\Hash\Hasher\Password as PasswordHasher;

class AuthenticationManagement
{
    private $hasher;
    private $dataManagement;
    public function __construct()
    {
        $this->hasher = new PasswordHasher();
        $this->dataManagement = new DatabaseManagement();
    }
    public function login($email, $password)
    {
        if ($this->dataManagement->fetchOne("user", "email=:email", array(":email" => $email))) {
            $storedPassword = $this->getPassword($email);
            if ($storedPassword === $password) {
                // code to login user
                return true;
            } else {
                return false;
            }
        }
    }

    public function logout()
    {
        // code to logout user
    }

    public function register($name, $email, $password)
    {
        $hashedPassword = $this->hasher->hash($password);
        $this->dataManagement->insert("user", "name, email, password", array("name" => $name, "email" => $email, "password" => $hashedPassword));
    }

    private function getPassword($email)
    {
        return true;
    }
}
