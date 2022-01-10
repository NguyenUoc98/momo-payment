<?php
/**
 * Created by PhpStorm.
 * Filename: Process.php
 * User: Nguyễn Văn Ước
 * Date: 29/12/2021
 * Time: 00:57
 */

namespace Uocnv\MomoPayment\Client;

use Uocnv\MomoPayment\Services\Environment;

abstract class Process
{
    protected $environment;
    protected $partnerInfo;

    /**
     * Process constructor.
     * @param $environment
     */
    public function __construct(Environment $environment)
    {
        $this->environment = $environment;
        $this->partnerInfo = $environment->getPartnerInfo();
    }

    /**
     * @return mixed
     */
    public function getEnvironment()
    {
        return $this->environment;
    }

    /**
     * @param mixed $environment
     */
    public function setEnvironment($environment): void
    {
        $this->environment = $environment;
    }

    /**
     * @return mixed
     */
    public function getPartnerInfo()
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
}