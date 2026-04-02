<?php

namespace Obelaw\Basketin\Cart\Delta;

use Obelaw\Basketin\Cart\Services\CartManager;

class DeltaContext
{
    public CartManager $cart;
    public float $originalPrice;
    public float $currentPrice;
    public array $appliedDiscounts = [];
    public array $appliedSurcharges = [];

    public function __construct(CartManager $cart, float $originalPrice)
    {
        $this->cart = $cart;
        $this->originalPrice = $originalPrice;
        $this->currentPrice = $originalPrice;
    }

    public function applyDiscount(float $amount, string $name): self
    {
        $amount = round($amount, 2);

        if ($amount > $this->currentPrice) {
            $amount = $this->currentPrice;
        }

        if ($amount > 0) {
            $this->currentPrice = round($this->currentPrice - $amount, 2);
            $this->appliedDiscounts[] = [
                'name' => $name,
                'amount' => $amount,
            ];
        }

        return $this;
    }

    public function applySurcharge(float $amount, string $name): self
    {
        $amount = round($amount, 2);

        if ($amount > 0) {
            $this->currentPrice = round($this->currentPrice + $amount, 2);
            $this->appliedSurcharges[] = [
                'name' => $name,
                'amount' => $amount,
            ];
        }

        return $this;
    }

    public function hasApplied(string $ruleName): bool
    {
        foreach ($this->appliedDiscounts as $discount) {
            if ($discount['name'] === $ruleName) {
                return true;
            }
        }
        return false;
    }

    public function hasAppliedSurcharge(string $ruleName): bool
    {
        foreach ($this->appliedSurcharges as $surcharge) {
            if ($surcharge['name'] === $ruleName) {
                return true;
            }
        }
        return false;
    }

    public function getAppliedNames(): array
    {
        return array_column($this->appliedDiscounts, 'name');
    }
}
