<?php
/**
 * Created by PhpStorm.
 * Filename: CaptureMoMoResponse.php
 * User: Nguyễn Văn Ước
 * Date: 29/12/2021
 * Time: 01:07
 */

namespace Uocnv\MomoPayment\Client;

use Uocnv\MomoPayment\Services\RequestType;

class CaptureMoMoResponse extends AIOResponse
{
    private $payUrl;
    private $deeplink;
    private $deeplinkWebInApp;
    private $qrCodeUrl;

    public function __construct(array $params = array())
    {
        parent::__construct($params);
        $vars = get_object_vars($this);

        foreach ($vars as $key => $value) {
            if (array_key_exists($key, $params)) {
                $this->{$key} = $params[$key];
            }
        }

        $this->setRequestType(RequestType::CAPTURE_MOMO_WALLET);

    }

    /**
     * @return mixed
     */
    public function getPayUrl()
    {
        return $this->payUrl;
    }

    /**
     * @param mixed $payUrl
     */
    public function setPayUrl($payUrl): void
    {
        $this->payUrl = $payUrl;
    }

    /**
     * @return mixed
     */
    public function getDeeplink()
    {
        return $this->deeplink;
    }

    /**
     * @param mixed $deeplink
     */
    public function setDeeplink($deeplink): void
    {
        $this->deeplink = $deeplink;
    }

    /**
     * @return mixed
     */
    public function getDeeplinkWebInApp()
    {
        return $this->deeplinkWebInApp;
    }

    /**
     * @param mixed $deeplinkWebInApp
     */
    public function setDeeplinkWebInApp($deeplinkWebInApp): void
    {
        $this->deeplinkWebInApp = $deeplinkWebInApp;
    }

    /**
     * @return mixed
     */
    public function getQrCodeUrl()
    {
        return $this->qrCodeUrl;
    }

    /**
     * @param mixed $qrCodeUrl
     */
    public function setQrCodeUrl($qrCodeUrl): void
    {
        $this->qrCodeUrl = $qrCodeUrl;
    }
}