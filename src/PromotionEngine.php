<?php

namespace Obelaw\Basketin\Cart\Promotions;

use Obelaw\Basketin\Cart\Promotions\Contracts\PromotionRule;
use Obelaw\Basketin\Cart\Services\CartManager;
use Obelaw\Basketin\Cart\Services\TotalManager;

class PromotionEngine
{
    protected $cart;
    protected $totals;
    protected $rules = [];
    /**
     * List of applied rules with their details.
     *
     * @var array
     */
    protected $appliedRules = [];

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
        $this->appliedRules = []; // Reset applied rules list

        foreach ($this->rules as $rule) {
            $discount = $rule->calculate($this->cart);

            if ($discount > 0) {
                $this->totals->applyDiscount($discount, $rule->getName());
                // Store the applied rule details
                $this->appliedRules[] = [
                    'name' => $rule->getName(),
                    'discount_amount' => $discount,
                    'rule_type' => get_class($rule),
                ];
            }
        }

        return $this;
    }

    /**
     * Get the list of applied rules.
     *
     * @return array
     */
    public function getAppliedRules(): array
    {
        return $this->appliedRules;
    }
}
