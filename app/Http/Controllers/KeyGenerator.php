<?php
require_once('..\..\..\vendor\autoload.php');

use Defuse\Crypto\Key;

$key = Key::createNewRandomKey();
echo $key->saveToAsciiSafeString();
