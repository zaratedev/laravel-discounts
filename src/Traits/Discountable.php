<?php

namespace Zaratedev\Discounts\Traits;

use Illuminate\Database\Eloquent\Relations\MorphMany;
use Zaratedev\Discounts\Discounts;
use Zaratedev\Discounts\Models\Discount;

trait Discountable
{
    /**
     * Define an morph-one or many relationship.
     *
     * @return \Illuminate\Database\Eloquent\Relations\MorphMany
     */
    public function discounts(): MorphMany
    {
        return $this->morphMany(Discount::class, 'discountable');
    }

    /**
     * Create discounts for the model.
     *
     * @param  int  $quantity
     * @param  int  $amount amount in cents.
     * @param  null  $expires_at
     * @return \App\Models\Discount[]
     */
    public function createDiscounts(int $quantity, int $amount, $expires_at = null)
    {
        return Discounts::create($this, $quantity, $amount, $expires_at);
    }

    /**
     * Create a new discount for the model.
     *
     * @param  int  $amount
     * @param  null  $expires_at
     * @return \App\Models\Discount
     */
    public function createDiscount(int $amount, $expires_at = null): Discount
    {
        $discounts = Discounts::create($this, 1, $amount, $expires_at);

        return $discounts[0];
    }
}
