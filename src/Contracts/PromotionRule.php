<?php

namespace Obelaw\Basketin\Cart\Delta\Contracts;

use Closure;
use Obelaw\Basketin\Cart\Delta\DiscountContext;
use Obelaw\Basketin\Cart\Delta\Enums\Priority;

interface PromotionRule
{
    public function getName(): string;

    public function getPriority(): Priority;

    public function calculate(DiscountContext $context): float;

    public function handle(DiscountContext $context, Closure $next);
}
