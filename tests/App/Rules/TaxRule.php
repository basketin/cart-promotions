<?php

namespace Obelaw\Basketin\Cart\Delta\Tests\App\Rules;

use Obelaw\Basketin\Cart\Delta\Contracts\DeltaRule;
use Obelaw\Basketin\Cart\Delta\DeltaContext;
use Obelaw\Basketin\Cart\Delta\Surcharge;

class TaxRule extends Surcharge implements DeltaRule
{
    protected ?string $name = 'tax rule';

    public function calculate(DeltaContext $context): float
    {
        return 99;
    }
}
