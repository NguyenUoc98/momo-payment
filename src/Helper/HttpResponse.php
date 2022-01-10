<?php
/**
 * Created by PhpStorm.
 * Filename: HttpResponse.php
 * User: Nguyễn Văn Ước
 * Date: 29/12/2021
 * Time: 00:54
 */

namespace Uocnv\MomoPayment\Helper;

class HttpResponse
{
    protected $statusCode;
    protected $body;

    /**
     * HttpResponse constructor.
     * @param $statusCode
     * @param $body
     */
    public function __construct($statusCode, $body)
    {
        $this->statusCode = $statusCode;
        $this->body       = $body;
    }

    /**
     * @return mixed
     */
    public function getStatusCode()
    {
        return $this->statusCode;
    }

    /**
     * @param mixed $statusCode
     */
    public function setStatusCode($statusCode): void
    {
        $this->statusCode = $statusCode;
    }

    /**
     * @return mixed
     */
    public function getBody()
    {
        return $this->body;
    }

    /**
     * @param mixed $body
     */
    public function setBody($body): void
    {
        $this->body = $body;
    }
}