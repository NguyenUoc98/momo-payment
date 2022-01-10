<?php
/**
 * Created by PhpStorm.
 * Filename: Encoder.php
 * User: Nguyễn Văn Ước
 * Date: 29/12/2021
 * Time: 00:48
 */

namespace Uocnv\MomoPayment\Helper;

use phpseclib\Crypt\RSA;

class Encoder
{
    public static function hashSha256($rawData, $secretKey = null)
    {
        $signature = hash_hmac("sha256", $rawData, $secretKey);
        return $signature;
    }

    public static function encryptRSA(array $rawData, $publicKey)
    {
        $rawJson = json_encode($rawData, JSON_UNESCAPED_UNICODE);

        $rsa = new RSA();
        $rsa->loadKey($publicKey);
        $rsa->setEncryptionMode(RSA::ENCRYPTION_PKCS1);

        $cipher = $rsa->encrypt($rawJson);
        return base64_encode($cipher);
    }

    public static function decryptRSA($hashData, $privateKey)
    {
        $rsa = new RSA();
        $rsa->loadKey($privateKey);
        $rsa->setEncryptionMode(RSA::ENCRYPTION_PKCS1);
        return $rsa->decrypt(base64_decode($hashData));
    }
}