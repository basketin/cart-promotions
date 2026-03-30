<?php

namespace Obelaw\Basketin\Cart\Promotions;

use Closure;

abstract class Promotion
{
    protected ?string $name = null;

    public function getName(): string
    {
        return $this->name ?? static::class;
    }

    abstract public function calculate(DiscountContext $context): float;

    public function handle(DiscountContext $context, Closure $next)
    {
        $discount = $this->calculate($context);

        if ($discount > 0) {
            $context->applyDiscount($discount, $this->getName());
        }

        return $next($context);
    }
}
