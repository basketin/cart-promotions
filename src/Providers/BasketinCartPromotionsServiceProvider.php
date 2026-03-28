<?php

namespace Obelaw\Basketin\Cart\Promotions\Providers;

use Illuminate\Support\ServiceProvider;
use Obelaw\Basketin\Cart\Promotions\PromotionEngine;
use Obelaw\Basketin\Cart\Services\TotalManager;

class BasketinCartPromotionsServiceProvider extends ServiceProvider
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
