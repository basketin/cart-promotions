<?php

namespace Obelaw\Basketin\Cart\Promotions;

use Illuminate\Pipeline\Pipeline;
use Obelaw\Basketin\Cart\Promotions\Contracts\PromotionRule;
use Obelaw\Basketin\Cart\Services\CartManager;
use Obelaw\Basketin\Cart\Services\TotalManager;

class PromotionEngine
{
    protected CartManager $cart;
    protected TotalManager $totals;
    protected array $rules = [];
    protected array $appliedRules = [];

    public function __construct(CartManager $cart, ?TotalManager $totals = null)
    {
        $this->cart = $cart;
        $this->totals = $totals ?? $cart->totals();
    }

    public function rule(PromotionRule $rule): self
    {
        $this->rules[] = $rule;
        return $this;
    }

    public function apply(): self
    {
        $this->appliedRules = [];

        $subtotal = $this->totals->getSubtotal();
        $context = new DiscountContext($this->cart, $subtotal);

        app(Pipeline::class)
            ->send($context)
            ->through($this->rules)
            ->thenReturn();

        foreach ($context->appliedDiscounts as $discount) {
            $this->totals->applyDiscount($discount['amount'], $discount['name']);
            $this->appliedRules[] = [
                'name' => $discount['name'],
                'discount_amount' => $discount['amount'],
                'rule_type' => null,
            ];
        }

        return $this;
    }

    public function getAppliedRules(): array
    {
        return $this->appliedRules;
    }
}
