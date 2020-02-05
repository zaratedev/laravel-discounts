<?php

namespace Zaratedev\Discounts\Exceptions;

use Zaratedev\Discounts\Models\Discount;

class DiscountExpired extends \Exception
{
    protected $message = 'The Discount is already expired.';

    /**
     * The discount.
     *
     * @var \App\Models\Discount
     */
    protected $discount;

    /**
     * DiscountExpired constructor.
     *
     * @param  \App\Models\Discount  $discount
     */
    public function __construct(Discount $discount)
    {
        $this->discount = $discount;
    }

    /**
     * @param  \App\Models\Discount $discount
     * @return mixed
     */
    public static function create(Discount $discount)
    {
        return new static($discount);
    }
}
