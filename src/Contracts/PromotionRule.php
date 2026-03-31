<?php

namespace Obelaw\Basketin\Cart\Promotions\Contracts;

use Closure;
use Obelaw\Basketin\Cart\Promotions\DiscountContext;
use Obelaw\Basketin\Cart\Promotions\Enums\Priority;

interface PromotionRule
{
    public function getName(): string;

    public function getPriority(): Priority;

    public function calculate(DiscountContext $context): float;

    public function handle(DiscountContext $context, Closure $next);
}
