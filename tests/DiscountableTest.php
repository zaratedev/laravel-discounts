<?php

namespace Zaratedev\Discounts\Tests;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Zaratedev\Discounts\Models\Discount;
use Zaratedev\Discounts\Tests\Models\Item;

class DiscountableTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    public function it_can_have_morph_many_discounts()
    {
        $model = new Item();

        $relation = $model->discounts();

        $this->assertInstanceOf(\Illuminate\Database\Eloquent\Relations\MorphMany::class, $relation);
        $this->assertEquals('discountable_id', $relation->getForeignKeyName());
        $this->assertEquals(Discount::class, get_class($relation->getRelated()));
    }

    /** @test */
    public function it_can_creates_new_discounts()
    {
        $item = Item::create(['name' => 'Foo']);

        $this->assertEquals(0, $item->discounts()->count());

        $discounts = $item->createDiscounts(10, 100);

        $this->assertEquals(10, $item->discounts()->count());
    }

    /** @test */
    public function models_can_create_a_discount()
    {
        $item = Item::create(['name' => 'Foo']);

        $discount = $item->createDiscount(100);

        $this->assertEquals(1, $item->discounts()->count());
        $this->assertInstanceOf(Discount::class, $discount);
        $this->assertSame($discount->discountable->id, $item->id);
    }
}
