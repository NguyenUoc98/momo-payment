<?php
/**
 * Created by PhpStorm.
 * Filename: HttpClient.php
 * User: Nguyễn Văn Ước
 * Date: 29/12/2021
 * Time: 00:54
 */

namespace Uocnv\MomoPayment\Helper;

class HttpClient
{
    public static function HTTPPost($url, string $payload)
    {
        $ch = curl_init();

        curl_setopt($ch, CURLOPT_POST, true);
        curl_setopt($ch, CURLOPT_HEADER, false);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_HTTPHEADER, array("Content-Type: application/json; charset=UTF-8"));
        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_POSTFIELDS, $payload);

        $result     = curl_exec($ch);
        $statusCode = curl_getinfo($ch, CURLINFO_HTTP_CODE);
        curl_close($ch);

        return new HttpResponse($statusCode, $result);
    }
}