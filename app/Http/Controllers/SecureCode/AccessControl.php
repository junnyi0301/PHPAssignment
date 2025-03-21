<?php

class AccessControl
{
    private $role;
    public function __construct($role)
    {
        $this->role = $role;
    }

    public function isAdmin()
    {
        return $this->role == 'admin';
    }

    public function isAllowed()
    {
        if (!($this->role == 'admin')) {
            abort(403, 'You are not authorized to access this page');
        }
    }
}