<?php

namespace Obelaw\Basketin\Cart\Promotions\Tests;

use Obelaw\Basketin\Cart\Promotions\Providers\BasketinCartPromotionsServiceProvider;
use Obelaw\Basketin\Cart\Promotions\Tests\App\Providers\BasketinCartPromotionsTestServiceProvider;
use Obelaw\Basketin\Cart\Providers\BasketinCartServiceProvider;
use Orchestra\Testbench\TestCase as BaseTestCase;


class TestCase extends BaseTestCase
{
    protected function setUp(): void
    {
        parent::setUp();

        $this->artisan('migrate:fresh', [
            '--database' => 'testing',
        ]);

        // additional setup
    }

    protected function getPackageProviders($app)
    {
        return [
            BasketinCartServiceProvider::class,
            BasketinCartPromotionsServiceProvider::class,
            BasketinCartPromotionsTestServiceProvider::class,
        ];
    }

    protected function getEnvironmentSetUp($app)
    {
        $app['config']->set('app.key', 'AckfSECXIvnK5r28GVIWUAxmbBbBTsmF');
        $app['config']->set('database.default', 'testing');
        $app['config']->set('database.connections.testing', [
            'driver' => 'sqlite',
            'database' => ':memory:',
            'prefix' => '',
        ]);
        // ensure package models use the testing connection instead of the default package connection
        $app['config']->set('basketin.cart.connection', 'testing');
        $app['config']->set('basketin.cart.setup.auto_migrate', true);
    }
}
