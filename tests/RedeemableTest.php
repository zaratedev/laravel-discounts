<?php

namespace Zaratedev\Discounts\Tests;

use Discounts;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Event;
use Zaratedev\Discounts\Exceptions\DiscountExpired;
use Zaratedev\Discounts\Models\Discount;
use Zaratedev\Discounts\Tests\Models\Item;

class RedeemableTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    public function it_has_a_redeem_method()
    {
        Event::fake();

        $item = Item::create(['name' => 'Foo']);
        $discount = $item->createDiscount(100);

        $discount->redeem();

        $this->assertTrue($discount->exists);
        $this->assertNotNull($discount->redeemed_at);
        Event::assertDispatched('eloquent.redeeming: '.Discount::class);
        Event::assertDispatched('eloquent.redeemed: '.Discount::class);
    }

    /** @test */
    public function it_has_a_query_scopes_to_retrieve_redeemed_records()
    {
        $item = Item::create(['name' => 'Foo']);

        $item->createDiscounts(2, 100);
        $discount = $item->createDiscount(100);

        $discount->redeem();

        $this->assertEquals(1, Discount::redeemed()->count());
        $this->assertEquals(2, Discount::notRedeemed()->count());
    }

    /** @test */
    public function it_adds_to_the_observable_events()
    {
        $model = new Discount();

        $this->assertContains('redeeming', $model->getObservableEvents());
        $this->assertContains('redeemed', $model->getObservableEvents());
    }

    /** @test */
    public function it_knows_if_it_has_been_redeemed()
    {
        $model = new Discount();
        $this->assertFalse($model->isRedeemed());
        $this->assertTrue($model->isNotRedeemed());

        $model->setAttribute('redeemed_at', now());

        $this->assertTrue($model->isRedeemed());
        $this->assertFalse($model->isNotRedeemed());
    }

    /** @test */
    public function it_knows_if_it_has_been_expired()
    {
        $model = new Discount();
        $this->assertFalse($model->isExpired());
        $this->assertTrue($model->isNotExpired());

        $model->setAttribute('expires_at', now());

        $this->assertTrue($model->isExpired());
        $this->assertFalse($model->isNotExpired());
    }

    /** @test */
    public function it_can_not_redeem_expired_discount()
    {
        $this->expectException(DiscountExpired::class);

        $item = Item::create(['name' => 'Foo']);

        $discounts = Discounts::create($item, 1, 100, today()->subDay());
        $discount = $discounts[0];

        $discount->redeem();
    }
}
