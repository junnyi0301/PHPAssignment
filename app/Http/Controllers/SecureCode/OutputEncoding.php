<?php

class OutputEncoding
{
    public function __construct() {}

    public function sanitize($string)
    {
        return htmlspecialchars($string, ENT_QUOTES, 'UTF-8');
    }
}