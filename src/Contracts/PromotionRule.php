<?php

namespace Obelaw\Basketin\Cart\Delta\Contracts;

use Closure;
use Obelaw\Basketin\Cart\Delta\DeltaContext;
use Obelaw\Basketin\Cart\Delta\Enums\Priority;

interface PromotionRule
{
    public function getName(): string;

    public function getPriority(): Priority;

    public function calculate(DeltaContext $context): float;

    public function handle(DeltaContext $context, Closure $next);
}
