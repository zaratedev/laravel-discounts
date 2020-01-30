<?php

namespace Zaratedev\Discounts;

use Illuminate\Database\Eloquent\Model;
use Zaratedev\Discounts\Models\Discount;

class Discounts
{
    public static function create(Model $model, int $quantity = 1, $amount, $expires_at = null)
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
