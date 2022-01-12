<?php
/**
 * Created by PhpStorm.
 * Filename: QueryStatusResponse.php
 * User: Nguyễn Văn Ước
 * Date: 12/01/2022
 * Time: 15:03
 */

namespace Uocnv\MomoPayment\Client;

use Uocnv\MomoPayment\Services\RequestType;

class QueryStatusResponse extends AIOResponse
{
    public function __construct(array $params = array())
    {
        parent::__construct($params);
        $this->setRequestType(RequestType::TRANSACTION_STATUS);
    }
}