<?php
/**
 * Created by PhpStorm.
 * Filename: QueryStatusTransaction.php
 * User: Nguyễn Văn Ước
 * Date: 12/01/2022
 * Time: 15:04
 */

namespace Uocnv\MomoPayment\Client;

use Uocnv\MomoPayment\Exceptions\MomoException;
use Uocnv\MomoPayment\Helper\Converter;
use Uocnv\MomoPayment\Helper\Encoder;
use Uocnv\MomoPayment\Helper\HttpClient;
use Uocnv\MomoPayment\Services\Environment;
use Uocnv\MomoPayment\Services\Parameter;
use Uocnv\MomoPayment\Services\RequestType;

class QueryStatusTransaction extends Process
{
    public function __construct(Environment $environment)
    {
        parent::__construct($environment);
    }

//    public static function process(Environment $env, $orderId, $requestId)
//    {
//        $queryStatusTransaction = new QueryStatusTransaction($env);
//
//        try {
//            $queryStatusRequest = $queryStatusTransaction->createQueryStatusRequest($orderId, $requestId);
//            return $queryStatusTransaction->execute($queryStatusRequest);
//        } catch (MoMoException $exception) {
//            $queryStatusTransaction->logger->error($exception->getErrorMessage());
//        }
//    }

    public function createQueryStatusRequest($orderId, $requestId): QueryStatusRequest
    {

        $rawData = Parameter::PARTNER_CODE . "=" . $this->getPartnerInfo()->getPartnerCode() .
            "&" . Parameter::ACCESS_KEY . "=" . $this->getPartnerInfo()->getAccessKey() .
            "&" . Parameter::REQUEST_ID . "=" . $requestId .
            "&" . Parameter::ORDER_ID . "=" . $orderId .
            "&" . Parameter::REQUEST_TYPE . "=" . RequestType::TRANSACTION_STATUS;

        $signature = Encoder::hashSha256($rawData, $this->getPartnerInfo()->getSecretKey());

        $arr = array(
            Parameter::PARTNER_CODE => $this->getPartnerInfo()->getPartnerCode(),
            Parameter::ACCESS_KEY => $this->getPartnerInfo()->getAccessKey(),
            Parameter::REQUEST_ID => $requestId,
            Parameter::ORDER_ID => $orderId,
            Parameter::SIGNATURE => $signature,
        );

        return new QueryStatusRequest($arr);
    }

    public function execute($queryStatusRequest)
    {
        try {
            $data = Converter::objectToJsonStrNoNull($queryStatusRequest);
            $response = HttpClient::HTTPPost($this->getEnvironment()->getMomoEndpoint(), $data);

            if ($response->getStatusCode() != 200) {
                throw new MomoException('[CaptureMoMoIPNRequest][' . $queryStatusRequest->getOrderId() . '] -> Error API');
            }

            $queryStatusResponse = new QueryStatusResponse(json_decode($response->getBody(), true));

            return $this->checkResponse($queryStatusResponse);

        } catch (MoMoException $exception) {
        }
        return null;
    }

    public function checkResponse(QueryStatusResponse $queryStatusResponse)
    {
        try {

            //check signature
            $rawHash = Parameter::PARTNER_CODE . "=" . $queryStatusResponse->getPartnerCode() .
                "&" . Parameter::ACCESS_KEY . "=" . $queryStatusResponse->getAccessKey() .
                "&" . Parameter::REQUEST_ID . "=" . $queryStatusResponse->getRequestId() .
                "&" . Parameter::ORDER_ID . "=" . $queryStatusResponse->getOrderId() .
                "&" . Parameter::ERROR_CODE . "=" . $queryStatusResponse->getErrorCode() .
                "&" . Parameter::TRANS_ID . "=" . $queryStatusResponse->getTransId() .
                "&" . Parameter::AMOUNT . "=" . $queryStatusResponse->getAmount() .
                "&" . Parameter::MESSAGE . "=" . $queryStatusResponse->getMessage() .
                "&" . Parameter::LOCAL_MESSAGE . "=" . $queryStatusResponse->getLocalMessage() .
                "&" . Parameter::REQUEST_TYPE . "=" . $queryStatusResponse->getRequestType() .
                "&" . Parameter::PAY_TYPE . "=" . $queryStatusResponse->getPayType() .
                "&" . Parameter::EXTRA_DATA . "=" . $queryStatusResponse->getExtraData();

            $signature = hash_hmac("sha256", $rawHash, $this->getPartnerInfo()->getSecretKey());

            if ($signature == $queryStatusResponse->getSignature())
                return $queryStatusResponse;
            else
                throw new MoMoException("Wrong signature from MoMo side - please contact with us");
        } catch (MoMoException $exception) {
        }
        return $queryStatusResponse;
    }
}