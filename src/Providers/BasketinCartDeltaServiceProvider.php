<?php

namespace Obelaw\Basketin\Cart\Delta\Providers;

use Illuminate\Support\ServiceProvider;
use Obelaw\Basketin\Cart\Delta\PromotionEngine;
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
            return new PromotionEngine($this->getCartService(), $this);
        });
    }
}
