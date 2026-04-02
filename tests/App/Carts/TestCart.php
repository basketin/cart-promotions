<?php

namespace Obelaw\Basketin\Cart\Delta\Tests\App\Carts;

use Obelaw\Basketin\Cart\Base\CartBase;
use Obelaw\Basketin\Cart\Contracts\HasManageTotals;
use Obelaw\Basketin\Cart\Delta\Tests\App\Rules\TestRule;
use Obelaw\Basketin\Cart\Services\TotalManager;

class TestCart extends CartBase implements HasManageTotals
{
    public function manageTotals(TotalManager $totals): void
    {
        $totals->delta()
            ->rule(new TestRule())
            ->apply();
    }
}
