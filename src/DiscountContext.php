<?php

namespace Obelaw\Basketin\Cart\Promotions;

use Obelaw\Basketin\Cart\Services\CartManager;

class DiscountContext
{
    public CartManager $cart;
    public float $originalPrice;
    public float $currentPrice;
    public array $appliedDiscounts = [];

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
}
