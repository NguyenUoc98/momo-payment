<?php
/**
 * Created by PhpStorm.
 * Filename: MomoException.php
 * User: Nguyễn Văn Ước
 * Date: 29/12/2021
 * Time: 00:46
 */

namespace Uocnv\MomoPayment\Exceptions;

class MomoException extends \Exception
{
    public function getErrorMessage(): string
    {
        return 'Error on line ' . $this->getLine() . ' in ' . $this->getFile()
            . ":\n" . $this->getMessage()
            . ":\n" . $this->getTraceAsString()
            . "\n";
    }
}