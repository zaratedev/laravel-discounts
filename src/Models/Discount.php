<?php

namespace Zaratedev\Discounts\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\MorphTo;
use Zaratedev\Discounts\Traits\Redeemable;

class Discount extends Model
{
    use Redeemable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'discountable_id',
        'discountable_type',
        'amount',
        'redeemed_at',
        'expires_at',
    ];

    /**
     * The attributes that should be mutated to dates.
     *
     * @var array
     */
    protected $dates = ['redeemed_at', 'expires_at'];

    /*
    |--------------------------------------------------------------------------
    | Eloquent Model Relationships
    |--------------------------------------------------------------------------
    */

    /**
     * Get the owning discountable model.
     *
     * @return \Illuminate\Database\Eloquent\Relations\MorphTo;
     */
    public function discountable(): MorphTo
    {
        return $this->morphTo();
    }
}
