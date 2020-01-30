<?php

namespace Zaratedev\Discounts\Facades;

use Illuminate\Support\Facades\Facade;

class Discounts extends Facade
{
    /**
     * Get the registered name of the component.
     *
     * @return string
     */
    protected static function getFacadeAccessor()
    {
        return 'discounts';
    }
}
