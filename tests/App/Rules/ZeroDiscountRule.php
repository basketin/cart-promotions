<?php

namespace Obelaw\Basketin\Cart\Delta\Tests\App\Rules;

use Obelaw\Basketin\Cart\Delta\Contracts\DeltaRule;
use Obelaw\Basketin\Cart\Delta\DeltaContext;
use Obelaw\Basketin\Cart\Delta\Promotion;

class ZeroDiscountRule extends Promotion implements DeltaRule
{
    protected ?string $name = 'zero discount rule';

    public function calculate(DeltaContext $context): float
    {
        return 0;
    }
}
