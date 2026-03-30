<?php

namespace Obelaw\Basketin\Cart\Promotions\Tests\App\Rules;

use Obelaw\Basketin\Cart\Promotions\Contracts\PromotionRule;
use Obelaw\Basketin\Cart\Promotions\DiscountContext;
use Obelaw\Basketin\Cart\Promotions\Promotion;

class ZeroDiscountRule extends Promotion implements PromotionRule
{
    protected ?string $name = 'zero discount rule';

    public function calculate(DiscountContext $context): float
    {
        return 0;
    }
}
