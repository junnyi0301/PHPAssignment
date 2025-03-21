<?php
require_once('..\..\..\vendor\autoload.php');

use Defuse\Crypto\Crypto;
use Defuse\Crypto\Key;

class CryptographicPractices
{
    private $key;
    public function __construct()
    {
        $this->key = Key::loadFromAsciiSafeString(getenv('ENCRYPTION_KEY'));
    }

    public function encrypt($data)
    {
        $data = base64_encode($data);
        $encrypted = Crypto::encrypt($data, $this->key);
        return $encrypted;
    }

    public function decrypt($data)
    {
        $data = base64_decode($data);
        $decrypted = Crypto::decrypt($data, $this->key);
        return base64_decode($decrypted);
    }
}
