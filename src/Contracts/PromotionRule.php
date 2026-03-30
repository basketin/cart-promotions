<?php

namespace Obelaw\Basketin\Cart\Promotions\Contracts;

use Closure;
use Obelaw\Basketin\Cart\Promotions\DiscountContext;

interface PromotionRule
{
    public function getName(): string;

    public function calculate(DiscountContext $context): float;

    public function handle(DiscountContext $context, Closure $next);
}
