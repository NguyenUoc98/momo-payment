<?php

namespace Uocnv\MomoPayment;

use Illuminate\Support\Facades\Facade;

/**
 * @see \Uocnv\MomoPayment\Skeleton\SkeletonClass
 */
class MomoPaymentFacade extends Facade
{
    /**
     * Get the registered name of the component.
     *
     * @return string
     */
    protected static function getFacadeAccessor()
    {
        return 'momo-payment';
    }
}
