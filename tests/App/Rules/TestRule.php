<?php

namespace Obelaw\Basketin\Cart\Promotions\Tests\App\Rules;

use Obelaw\Basketin\Cart\Promotions\Contracts\PromotionRule;
use Obelaw\Basketin\Cart\Promotions\Promotion;
use Obelaw\Basketin\Cart\Services\CartManager;

class TestRule extends Promotion implements PromotionRule
{
    protected ?string $name = 'test rule';

    public function calculate(CartManager $cart): float
    {
        return 100;
    }
}
