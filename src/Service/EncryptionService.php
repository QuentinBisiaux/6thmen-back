<?php

namespace App\Service;

use Defuse\Crypto\Crypto;
use Defuse\Crypto\Key;

class EncryptionService
{
    private string $deterministicKey;
    private Key $encryptionKey;

    public function __construct(string $encryptionKey, string $deterministicKey)
    {
        $this->deterministicKey = $deterministicKey;
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

    public function deterministicEncrypt(string $plainText): string
    {
        $iv = openssl_digest($this->deterministicKey, 'MD5', true); // Use a fixed IV based on the key
        if(!$iv) return '';
        return openssl_encrypt($plainText, 'AES-256-CBC', $this->deterministicKey, 0, $iv);
    }

    function deterministicDecrypt(string $encryptedText): string
    {
        $iv = openssl_digest($this->deterministicKey, 'MD5', true);
        if(!$iv) return '';
        return openssl_decrypt($encryptedText, 'AES-256-CBC', $this->deterministicKey, 0, $iv);
    }

}