# Laravel Discounts

[![Build Status](https://travis-ci.org/zaratedev/laravel-discounts.svg?branch=master)](https://travis-ci.org/zaratedev/laravel-discounts)
[![Total Downloads](https://poser.pugx.org/zaratedev/laravel-discounts/downloads)](https://packagist.org/packages/zaratedev/laravel-discounts)
[![License](https://poser.pugx.org/zaratedev/laravel-discounts/license)](https://packagist.org/packages/zaratedev/laravel-discounts)

This package is inspired by [Laravel Vouchers](https://github.com/beyondcode/laravel-vouchers) by Marcel Pociot.

Apply discounts to your Eloquent Models on Laravel, It can be used when we need to associate discounts with a certain amount to an eloquent model.

Any model

```php

<?php

use Zaratedev\Discounts\Traits\Discountable;

class Item extends Model
{
    use Discountable;
}

...

$item = Item::find(1);
$item->createDiscount(100);

```

## Installation

You can install the package via composer:

```bash
composer require zaratedev/laravel-discounts
```

The package will automatically register itself.

## Migrations

You can publish the migrations

```bash
php artisan vendor:publish --provider="Zaratedev\Discounts\DiscountsServiceProvider" --tag="migrations"
```

Execute the command
```bash
php artisan migrate
```

## Usage

The basic concept of this package is to create discounts, associated with a specific model. For example, you have a subscription application where the first three months must apply a discount to the subscription price.

Add the `Zaratedev\Discounts\Traits\Discountable` trait to your eloquent model that you want to use with discounts.

El trait `Zaratedev\Discounts\Traits\Discountable` can redeem discounts in the database.

## Creating discounts

### Using the facade

You can create one or many discounts using `Discounts` facade:

```php
$subscription = Subscription::find(1);

$discounts = Discounts::create($subscription, 3, 100);
```

### Using the Eloquent model

```php
$subscription = Subscription::find(1);

// Returns an array of Discounts
$discounts = $subscription->createDiscounts(3, 100);

// Return a Discount model

$discount = $subscription->createDiscount(100);
```

### Discounts with expiry dates

You can create discounts with expiration date.

```php
$subscription = Subscription::find(1);

$subscription->createDiscounts(3, 100, today()->addMonths(4))
```

### Redeeming Discounts

You can redeem the discount when it has been used.

```php
$discount->redeem();
```

After redeeming a discount, this package initializes two observable events `redeeming`, `redeemed` so you can implement the events and listeners according to the bussines logic of your application.

### Discount expired

If a discount tries to redeem an expired discount, the package will throw the following exception: `Zaratedev\Discounts\Exceptions\DiscountExpired`.

## Contributing
Pull requests are welcome. For major changes, please open an issue first to discuss what you would like to change.

Please make sure to update tests as appropriate.

## Contact

If you find a problem with this package, please send email to zaratedev@gmail.com

## License
[MIT](./LICENSE.md)
