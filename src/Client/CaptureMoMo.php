<?php
/**
 * Created by PhpStorm.
 * Filename: CaptureMoMo.php
 * User: Nguyễn Văn Ước
 * Date: 29/12/2021
 * Time: 01:00
 */

namespace Uocnv\MomoPayment\Client;

use Uocnv\MomoPayment\Exceptions\MomoException;
use Uocnv\MomoPayment\Helper\Converter;
use Uocnv\MomoPayment\Helper\Encoder;
use Uocnv\MomoPayment\Helper\HttpClient;
use Uocnv\MomoPayment\Services\Environment;
use Uocnv\MomoPayment\Services\Parameter;

class CaptureMoMo extends Process
{
    public function __construct(Environment $environment)
    {
        parent::__construct($environment);
    }

    public function createCaptureMoMoRequest(
        $orderId,
        $orderInfo,
        string $amount,
        $extraData,
        $requestId,
        $notifyUrl,
        $returnUrl
    ): CaptureMoMoRequest {

        $rawData = Parameter::PARTNER_CODE . "=" . $this->getPartnerInfo()->getPartnerCode() .
            "&" . Parameter::ACCESS_KEY . "=" . $this->getPartnerInfo()->getAccessKey() .
            "&" . Parameter::REQUEST_ID . "=" . $requestId .
            "&" . Parameter::AMOUNT . "=" . $amount .
            "&" . Parameter::ORDER_ID . "=" . $orderId .
            "&" . Parameter::ORDER_INFO . "=" . $orderInfo .
            "&" . Parameter::RETURN_URL . "=" . $returnUrl .
            "&" . Parameter::NOTIFY_URL . "=" . $notifyUrl .
            "&" . Parameter::EXTRA_DATA . "=" . $extraData;

        $signature = Encoder::hashSha256($rawData, $this->getPartnerInfo()->getSecretKey());

        $arr = array(
            Parameter::PARTNER_CODE => $this->getPartnerInfo()->getPartnerCode(),
            Parameter::ACCESS_KEY   => $this->getPartnerInfo()->getAccessKey(),
            Parameter::REQUEST_ID   => $requestId,
            Parameter::AMOUNT       => $amount,
            Parameter::ORDER_ID     => $orderId,
            Parameter::ORDER_INFO   => $orderInfo,
            Parameter::RETURN_URL   => $returnUrl,
            Parameter::NOTIFY_URL   => $notifyUrl,
            Parameter::EXTRA_DATA   => $extraData,
            Parameter::SIGNATURE    => $signature,
        );

        return new CaptureMoMoRequest($arr);
    }

    public function execute($captureMoMoRequest)
    {
        try {
            $data = Converter::objectToJsonStrNoNull($captureMoMoRequest);
            $response = HttpClient::HTTPPost($this->getEnvironment()->getMomoEndpoint(), $data);

            if ($response->getStatusCode() != 200) {
                throw new MomoException('[CaptureMoMoResponse][' . $captureMoMoRequest->getOrderId() . '] -> Error API');
            }

            $captureMoMoResponse = new CaptureMoMoResponse(json_decode($response->getBody(), true));

            return $this->checkResponse($captureMoMoResponse);

        } catch (MoMoException $e) {
        }
        return null;
    }

    public function checkResponse(CaptureMoMoResponse $captureMoMoResponse)
    {
        try {

            //check signature
            $rawHash = Parameter::REQUEST_ID . "=" . $captureMoMoResponse->getRequestId() .
                "&" . Parameter::ORDER_ID . "=" . $captureMoMoResponse->getOrderId() .
                "&" . Parameter::MESSAGE . "=" . $captureMoMoResponse->getMessage() .
                "&" . Parameter::LOCAL_MESSAGE . "=" . $captureMoMoResponse->getLocalMessage() .
                "&" . Parameter::PAY_URL . "=" . $captureMoMoResponse->getPayUrl() .
                "&" . Parameter::ERROR_CODE . "=" . $captureMoMoResponse->getErrorCode() .
                "&" . Parameter::REQUEST_TYPE . "=" . $captureMoMoResponse->getRequestType();

            $signature = hash_hmac("sha256", $rawHash, $this->getPartnerInfo()->getSecretKey());

            if ($signature == $captureMoMoResponse->getSignature()) {
                return $captureMoMoResponse;
            } else {
                throw new MoMoException("Wrong signature from MoMo side - please contact with us");
            }
        } catch (MoMoException $exception) {
        }
        return null;
    }

    public function checkResultResponse(CaptureMoMoResponse $captureMoMoResponse)
    {
        try {

            //check signature
            $rawHash = Parameter::PARTNER_CODE . "=" . $captureMoMoResponse->getPartnerCode() .
                "&" . Parameter::ACCESS_KEY . "=" . $captureMoMoResponse->getAccessKey() .
                "&" . Parameter::REQUEST_ID . "=" . $captureMoMoResponse->getRequestId() .
                "&" . Parameter::AMOUNT . "=" . $captureMoMoResponse->getAmount() .
                "&" . Parameter::ORDER_ID . "=" . $captureMoMoResponse->getOrderId() .
                "&" . Parameter::ORDER_INFO . "=" . $captureMoMoResponse->getOrderInfo() .
                "&" . Parameter::ORDER_TYPE . "=" . $captureMoMoResponse->getOrderType() .
                "&" . Parameter::TRANS_ID . "=" . $captureMoMoResponse->getTransId() .
                "&" . Parameter::MESSAGE . "=" . $captureMoMoResponse->getMessage() .
                "&" . Parameter::LOCAL_MESSAGE . "=" . $captureMoMoResponse->getLocalMessage() .
                "&" . Parameter::DATE . "=" . $captureMoMoResponse->getResponseTime() .
                "&" . Parameter::ERROR_CODE . "=" . $captureMoMoResponse->getErrorCode() .
                "&" . Parameter::PAY_TYPE . "=" . $captureMoMoResponse->getPayType() .
                "&" . Parameter::EXTRA_DATA . "=" . $captureMoMoResponse->getExtraData();

            $signature = hash_hmac("sha256", $rawHash, $this->getPartnerInfo()->getSecretKey());

            if ($signature == $captureMoMoResponse->getSignature()) {
                return $captureMoMoResponse;
            } else {
                throw new MoMoException("Wrong signature from MoMo side - please contact with us");
            }
        } catch (MoMoException $exception) {
        }
        return null;
    }
}