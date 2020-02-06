<?php

namespace Zaratedev\Discounts;

use Illuminate\Database\Eloquent\Model;
use Zaratedev\Discounts\Models\Discount;

class Discounts
{
    /**
     * Create discounts.
     *
     * @param  \Illuminate\Database\Eloquent\Model  $model
     * @param  int  $quantity
     * @param  int  $amount
     * @param  \Illuminate\Support\Carbon|null  $expires_at
     * @return array
     */
    public function create(Model $model, int $quantity, int $amount, $expires_at = null): array
    {
        $discounts = [];

        foreach (range(1, $quantity) as $i) {
            $discounts[] = Discount::create([
                'discountable_id' => $model->getKey(),
                'discountable_type' => $model->getMorphClass(),
                'amount' => $amount,
                'expires_at' => $expires_at,
            ]);
        }

        return $discounts;
    }
}
