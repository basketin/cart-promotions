<?php

namespace Obelaw\Basketin\Cart\Promotions\Tests\App\Rules;

use Obelaw\Basketin\Cart\Promotions\Contracts\PromotionRule;
use Obelaw\Basketin\Cart\Promotions\DiscountContext;
use Obelaw\Basketin\Cart\Promotions\Promotion;

class AnotherRule extends Promotion implements PromotionRule
{
    protected ?string $name = 'another rule';

    public function calculate(DiscountContext $context): float
    {
        return 50;
    }
}
