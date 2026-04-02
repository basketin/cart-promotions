<?php

namespace Obelaw\Basketin\Cart\Delta\Tests\App\Rules;

use Obelaw\Basketin\Cart\Delta\Contracts\PromotionRule;
use Obelaw\Basketin\Cart\Delta\DeltaContext;
use Obelaw\Basketin\Cart\Delta\Promotion;

class AnotherRule extends Promotion implements PromotionRule
{
    protected ?string $name = 'another rule';

    public function calculate(DeltaContext $context): float
    {
        return 50;
    }
}
