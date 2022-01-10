<?php
/**
 * Created by PhpStorm.
 * Filename: PartnerInfo.php
 * User: Nguyễn Văn Ước
 * Date: 29/12/2021
 * Time: 00:36
 */

namespace Uocnv\MomoPayment\Services;

class PartnerInfo
{
    private $accessKey;
    private $partnerCode;
    private $secretKey;

    /**
     * PartnerInfo constructor.
     * @param $accessKey
     * @param $partnerCode
     * @param $secretKey
     */
    public function __construct($accessKey, $partnerCode, $secretKey)
    {
        $this->accessKey   = $accessKey;
        $this->partnerCode = $partnerCode;
        $this->secretKey   = $secretKey;
    }

    /**
     * @return mixed
     */
    public function getAccessKey()
    {
        return $this->accessKey;
    }

    /**
     * @param mixed $accessKey
     */
    public function setAccessKey($accessKey): void
    {
        $this->accessKey = $accessKey;
    }

    /**
     * @return mixed
     */
    public function getPartnerCode()
    {
        return $this->partnerCode;
    }

    /**
     * @param mixed $partnerCode
     */
    public function setPartnerCode($partnerCode): void
    {
        $this->partnerCode = $partnerCode;
    }

    /**
     * @return mixed
     */
    public function getSecretKey()
    {
        return $this->secretKey;
    }

    /**
     * @param mixed $secretKey
     */
    public function setSecretKey($secretKey): void
    {
        $this->secretKey = $secretKey;
    }
}