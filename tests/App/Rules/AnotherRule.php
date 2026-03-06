<?php

namespace Obelaw\Basketin\Cart\Promotions\Tests\App\Rules;

use Obelaw\Basketin\Cart\Promotions\Contracts\PromotionRule;
use Obelaw\Basketin\Cart\Promotions\Promotion;
use Obelaw\Basketin\Cart\Services\CartService;

class AnotherRule extends Promotion implements PromotionRule
{
    protected ?string $name = 'another rule';

    public function calculate(CartService $cart): float
    {
        return 50;
    }
}
