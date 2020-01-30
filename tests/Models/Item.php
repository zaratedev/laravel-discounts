<?php

namespace Zaratedev\Discounts\Tests\Models;

use Illuminate\Database\Eloquent\Model;
use Zaratedev\Discounts\Traits\Discountable;

class Item extends Model
{
    use Discountable;

    protected $fillable = ['name'];
}
