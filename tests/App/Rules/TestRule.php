<?php

namespace Obelaw\Basketin\Cart\Delta\Tests\App\Rules;

use Obelaw\Basketin\Cart\Delta\Contracts\PromotionRule;
use Obelaw\Basketin\Cart\Delta\DeltaContext;
use Obelaw\Basketin\Cart\Delta\Promotion;

class TestRule extends Promotion implements PromotionRule
{
    protected ?string $name = 'test rule';

    public function calculate(DeltaContext $context): float
    {
        return 100;
    }
}
