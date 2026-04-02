<?php

namespace Obelaw\Basketin\Cart\Delta;

use Illuminate\Pipeline\Pipeline;
use Obelaw\Basketin\Cart\Delta\Contracts\DeltaRule;
use Obelaw\Basketin\Cart\Delta\Enums\Priority;
use Obelaw\Basketin\Cart\Services\CartManager;
use Obelaw\Basketin\Cart\Services\TotalManager;

class DeltaEngine
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

    public function rule(DeltaRule $rule): self
    {
        $this->rules[] = $rule;
        return $this;
    }

    public function apply(): self
    {
        $this->appliedRules = [];

        $subtotal = $this->totals->getSubtotal();
        $context = new DeltaContext($this->cart, $subtotal);

        $rules = collect($this->rules)->sortByDesc(fn($rule) => $rule->getPriority() instanceof Priority ? $rule->getPriority()->value : $rule->getPriority())->values()->all();

        app(Pipeline::class)
            ->send($context)
            ->through($rules)
            ->thenReturn();

        foreach ($context->appliedDiscounts as $discount) {
            $this->totals->applyDiscount($discount['amount'], $discount['name']);
            $this->appliedRules[] = [
                'name' => $discount['name'],
                'discount_amount' => $discount['amount'],
                'rule_type' => null,
            ];
        }

        foreach ($context->appliedSurcharges as $surcharge) {
            $this->totals->applyAddition($surcharge['amount'], $surcharge['name']);
            $this->appliedRules[] = [
                'name' => $surcharge['name'],
                'surcharge_amount' => $surcharge['amount'],
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
