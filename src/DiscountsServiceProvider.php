<?php

namespace Zaratedev\Discounts;

use Illuminate\Support\ServiceProvider;

class DiscountsServiceProvider extends ServiceProvider
{
    public function boot()
    {
        if ($this->app->runningInConsole()) {
            if (! class_exists('CreateDiscountsTable')) {
                $this->publishes([
                    __DIR__.'/../database/migrations/create_discounts_table.php.stub' => database_path('migrations/'.date('Y_m_d_His', time()).'_create_discounts_table.php'),
                ], 'migrations');
            }
        }
    }

    public function register()
    {
        $this->app->singleton('discounts', function () {
            return new Discounts();
        });
    }
}
