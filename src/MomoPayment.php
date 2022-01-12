<?php

namespace Uocnv\MomoPayment;

use Illuminate\Support\Arr;
use Uocnv\MomoPayment\Client\CaptureMoMo;
use Uocnv\MomoPayment\Client\CaptureMoMoResponse;
use Uocnv\MomoPayment\Client\QueryStatusTransaction;
use Uocnv\MomoPayment\Exceptions\MomoException;
use Uocnv\MomoPayment\Services\Environment;
use Uocnv\MomoPayment\Services\Parameter;
use Uocnv\MomoPayment\Services\PartnerInfo;

class MomoPayment
{
    private Environment $environment;

    public function __construct(string $mod)
    {

        $env               = in_array($mod, ['development', 'production']) ? $mod : 'development';
        $partnerInfo       = new PartnerInfo(config("momo-payment.$env.access_key"),
            config("momo-payment.$env.partner_code"), config("momo-payment.$env.secret_key"));
        $this->environment = new Environment(config("momo-payment.$env.end_point"), $partnerInfo, $env);
    }

    /**
     * Create request to payment
     *
     * @param array $data
     * @return CaptureMoMoResponse|null
     */
    public function createRequest(array $data)
    {
        $orderId   = Arr::get($data, 'orderId');
        $amount    = Arr::get($data, 'amount');
        $extraData = Arr::get($data, 'extraData');
        $requestId = Arr::get($data, 'requestId');
        $notifyUrl = Arr::get($data, 'notifyUrl', 'https://google.com.vn');
        $returnUrl = Arr::get($data, 'returnUrl');

        return self::process(
            $this->environment,
            $orderId,
            "Thanh toán đơn hàng $orderId",
            $amount,
            $extraData,
            $requestId,
            $notifyUrl,
            $returnUrl
        );
    }

    /**
     * Process create request to payment
     *
     * @param Environment $env
     * @param $orderId
     * @param $orderInfo
     * @param string $amount
     * @param $extraData
     * @param $requestId
     * @param $notifyUrl
     * @param $returnUrl
     * @return CaptureMoMoResponse|null
     */
    public static function process(
        Environment $env,
        $orderId,
        $orderInfo,
        string $amount,
        $extraData,
        $requestId,
        $notifyUrl,
        $returnUrl
    ) {
        $captureMoMoWallet = new CaptureMoMo($env);
        try {
            $captureMoMoRequest = $captureMoMoWallet->createCaptureMoMoRequest($orderId, $orderInfo, $amount,
                $extraData, $requestId, $notifyUrl, $returnUrl);
            return $captureMoMoWallet->execute($captureMoMoRequest);
        } catch (MomoException $exception) {
            return null;
        }
    }

    /**
     * Check status of transaction
     * @param $orderId
     * @param $requestId
     * @return Client\QueryStatusResponse|null
     */
    public function checkStatus($orderId, $requestId)
    {
        $queryStatusTransaction = new QueryStatusTransaction($this->environment);

        try {
            $queryStatusRequest = $queryStatusTransaction->createQueryStatusRequest($orderId, $requestId);
            return $queryStatusTransaction->execute($queryStatusRequest);
        } catch (MoMoException $exception) {
            return null;
        }
    }

    public function checkResult(array $response)
    {
        $captureMoMoWallet   = new CaptureMoMo($this->environment);
        $captureMoMoResponse = new CaptureMoMoResponse($response);
        return $captureMoMoWallet->checkResultResponse($captureMoMoResponse);
    }
}
