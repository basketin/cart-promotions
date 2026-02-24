<?php

namespace Obelaw\Basketin\Cart\Promotions;

use Obelaw\Basketin\Cart\Promotions\Contracts\PromotionRule;
use Obelaw\Basketin\Cart\Services\CartService;

class PromotionEngine
{
    protected $cart;
    protected $rules = [];
    protected $totalDiscount = 0;

    /**
     * List of applied rules with their details.
     *
     * @var array
     */
    protected $appliedRules = [];

    public function __construct(CartService $cart)
    {
        $this->cart = $cart;
    }

    public function rule(PromotionRule $rule): self
    {
        $this->rules[] = $rule;
        return $this;
    }

    public function apply(): self
    {
        $totalDiscount = 0;
        $this->appliedRules = []; // Reset applied rules list

        foreach ($this->rules as $rule) {
            $discount = $rule->calculate($this->cart);

            if ($discount > 0) {
                $totalDiscount += $discount;
                // Store the applied rule details
                $this->appliedRules[] = [
                    'name' => $rule->getName(), // Rule name (e.g., "Buy 1 Get 1 Free")
                    'discount_amount' => $discount,
                    'rule_type' => get_class($rule),
                ];
            }
        }

        $this->totalDiscount = $totalDiscount;
        return $this;
    }

    /**
     * Calculate the total discount from all registered rules.
     *
     * @return float
     */
    public function getDiscountTotal(): float
    {
        return $this->totalDiscount;
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
