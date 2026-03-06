<?php

namespace Obelaw\Basketin\Cart\Promotions\Tests\App\Carts;

use Obelaw\Basketin\Cart\Base\CartBase;
use Obelaw\Basketin\Cart\Contracts\HasManageTotals;
use Obelaw\Basketin\Cart\Promotions\Tests\App\Rules\TestRule;
use Obelaw\Basketin\Cart\Services\TotalService;

class TestCart extends CartBase implements HasManageTotals
{
    public function manageTotals(TotalService $totals): void
    {
        $totals->promotions()
            ->rule(new TestRule())
            ->apply();
    }
}
