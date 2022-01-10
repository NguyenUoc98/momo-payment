<?php
/**
 * Created by PhpStorm.
 * Filename: CaptureMoMoRequest.php
 * User: Nguyễn Văn Ước
 * Date: 29/12/2021
 * Time: 01:07
 */

namespace Uocnv\MomoPayment\Client;

use Uocnv\MomoPayment\Services\RequestType;

class CaptureMoMoRequest extends AIORequest
{
    public function __construct(array $params = array())
    {
        parent::__construct($params);
        $this->setRequestType(RequestType::CAPTURE_MOMO_WALLET);
    }
}