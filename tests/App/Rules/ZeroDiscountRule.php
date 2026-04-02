<?php

namespace Obelaw\Basketin\Cart\Delta\Tests\App\Rules;

use Obelaw\Basketin\Cart\Delta\Contracts\PromotionRule;
use Obelaw\Basketin\Cart\Delta\DiscountContext;
use Obelaw\Basketin\Cart\Delta\Promotion;

class ZeroDiscountRule extends Promotion implements PromotionRule
{
    protected ?string $name = 'zero discount rule';

    public function calculate(DiscountContext $context): float
    {
        return 0;
    }
}
