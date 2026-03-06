<?php

namespace Obelaw\Basketin\Cart\Promotions\Tests\App\Rules;

use Obelaw\Basketin\Cart\Promotions\Contracts\PromotionRule;
use Obelaw\Basketin\Cart\Promotions\Promotion;
use Obelaw\Basketin\Cart\Services\CartService;

class ZeroDiscountRule extends Promotion implements PromotionRule
{
    protected ?string $name = 'zero discount rule';

    public function calculate(CartService $cart): float
    {
        return 0;
    }
}
