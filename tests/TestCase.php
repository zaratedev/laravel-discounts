<?php

namespace Zaratedev\Discounts\Tests;

use Illuminate\Database\Schema\Blueprint;
use Zaratedev\Discounts\DiscountsServiceProvider;
use Zaratedev\Discounts\Facades\Discounts;

abstract class TestCase extends \Orchestra\Testbench\TestCase
{
    /**
     * Setup the test environment.
     */
    protected function setUp(): void
    {
        parent::setUp();

        $this->loadLaravelMigrations(['--database' => 'sqlite']);

        $this->setUpDatabase();
    }

    protected function getPackageProviders($app)
    {
        return [
            DiscountsServiceProvider::class,
        ];
    }

    protected function getPackageAliases($app)
    {
        return [
            'Discounts' => Discounts::class,
        ];
    }

    protected function getEnvironmentSetUp($app)
    {
        $app['config']->set('database.default', 'sqlite');

        $app['config']->set('database.connections.sqlite', [
            'driver' => 'sqlite',
            'database' => ':memory:',
            'prefix' => '',
        ]);
    }

    protected function setUpDatabase()
    {
        include_once __DIR__.'/../database/migrations/create_discounts_table.php.stub';
        (new \CreateDiscountsTable())->up();

        $this->app['db']->connection()->getSchemaBuilder()->create('items', function (Blueprint $table) {
            $table->increments('id');
            $table->string('name');
            $table->timestamps();
        });
    }
}
