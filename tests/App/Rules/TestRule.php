<?php

namespace Obelaw\Basketin\Cart\Delta\Tests\App\Rules;

use Obelaw\Basketin\Cart\Delta\Contracts\DeltaRule;
use Obelaw\Basketin\Cart\Delta\DeltaContext;
use Obelaw\Basketin\Cart\Delta\Promotion;

class TestRule extends Promotion implements DeltaRule
{
    protected ?string $name = 'test rule';

    public function calculate(DeltaContext $context): float
    {
        return 100;
    }
}
