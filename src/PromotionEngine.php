<?php

namespace Obelaw\Basketin\Cart\Promotions;

use Obelaw\Basketin\Cart\Promotions\Contracts\PromotionRule;
use Obelaw\Basketin\Cart\Services\CartService;

class PromotionEngine
{
    protected $cart;
    protected $rules = [];

    public function __construct(CartService $cart)
    {
        $this->cart = $cart;
    }

    public function apply(PromotionRule $rule): self
    {
        $this->rules[] = $rule;
        return $this;
    }

    public function getDiscountTotal(): float
    {
        $totalDiscount = 0;

        foreach ($this->rules as $rule) {
            $totalDiscount += $rule->calculate($this->cart);
        }

        return $totalDiscount;
    }
}
