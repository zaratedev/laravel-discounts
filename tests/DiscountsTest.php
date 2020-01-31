<?php

namespace Zaratedev\Discounts\Tests;

use Discounts;
use Zaratedev\Discounts\Tests\Models\Item;

class DiscountsTest extends TestCase
{
    /** @test */
    public function it_creates_discounts_and_associate_with_the_model()
    {
        $item = Item::create(['name' => 'Foo']);

        $discounts = Discounts::create($item, 1, 100);

        $this->assertCount(1, $discounts);
    }
}
