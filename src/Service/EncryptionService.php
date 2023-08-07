<?php

namespace App\Service;

use Defuse\Crypto\Crypto;
use Defuse\Crypto\Key;

class EncryptionService
{
    private Key $encryptionKey;

    public function __construct(string $encryptionKey)
    {
        $this->encryptionKey = Key::loadFromAsciiSafeString($encryptionKey);
    }

    public function encrypt(string $plainText): string
    {
        return Crypto::encrypt($plainText, $this->encryptionKey);
    }

    public function decrypt(string $encryptedText): string
    {
        return Crypto::decrypt($encryptedText, $this->encryptionKey);
    }

}