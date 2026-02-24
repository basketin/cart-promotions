<?php

namespace Obelaw\Basketin\Cart\Promotions\Contracts;

use Obelaw\Basketin\Cart\Services\CartService;

/**
 * Interface PromotionRule
 *
 * Contract for promotion rules used by the PromotionEngine.
 */
interface PromotionRule
{
    /**
     * Calculate discount for the provided cart.
     *
     * @param  CartService  $cart  The cart service instance
     * @return float  Calculated discount amount
     */
    public function calculate(CartService $cart): float;
}
