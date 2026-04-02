<?php

namespace Obelaw\Basketin\Cart\Delta\Providers;

use Illuminate\Support\ServiceProvider;
use Obelaw\Basketin\Cart\Delta\DeltaEngine;
use Obelaw\Basketin\Cart\Services\TotalManager;

class BasketinCartDeltaServiceProvider extends ServiceProvider
{
    /**
     * Register services.
     *
     * @return void
     */
    public function register()
    {
        //
    }

    /**
     * Bootstrap services.
     *
     * @return void
     */
    public function boot()
    {
        TotalManager::macro('promotions', function () {
            return new DeltaEngine($this->getCartService(), $this);
        });
    }
}
