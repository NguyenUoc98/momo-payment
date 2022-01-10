<?php
/**
 * Created by PhpStorm.
 * Filename: Environment.php
 * User: Nguyễn Văn Ước
 * Date: 29/12/2021
 * Time: 00:36
 */

namespace Uocnv\MomoPayment\Services;

class Environment
{
    private $momoEndpoint;
    private $partnerInfo;
    private $target;

    /**
     * Environment constructor.
     * @param $momoEndpoint
     * @param $partnerInfo
     * @param $target
     *
     */
    public function __construct($momoEndpoint, $partnerInfo, $target)
    {
        $this->momoEndpoint = $momoEndpoint;
        $this->partnerInfo  = $partnerInfo;
        $this->target       = $target;
    }

    /**
     * @return mixed
     */
    public function getMomoEndpoint()
    {
        return $this->momoEndpoint;
    }

    /**
     * @param mixed $momoEndpoint
     */
    public function setMomoEndpoint($momoEndpoint): void
    {
        $this->momoEndpoint = $momoEndpoint;
    }

    /**
     * @return mixed
     */
    public function getPartnerInfo(): PartnerInfo
    {
        return $this->partnerInfo;
    }

    /**
     * @param mixed $partnerInfo
     */
    public function setPartnerInfo($partnerInfo): void
    {
        $this->partnerInfo = $partnerInfo;
    }

    /**
     * @return mixed
     */
    public function getTarget()
    {
        return $this->target;
    }

    /**
     * @param mixed $target
     */
    public function setTarget($target): void
    {
        $this->target = $target;
    }
}