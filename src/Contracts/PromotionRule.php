<?php

namespace Obelaw\Basketin\Cart\Promotions\Contracts;

use Obelaw\Basketin\Cart\Services\CartManager;

/**
 * Interface PromotionRule
 *
 * Contract for promotion rules used by the PromotionEngine.
 */
interface PromotionRule
{
    /**
     * Get the name of the promotion rule.
     *
     * @return string
     */
    public function getName(): string;

    /**
     * Calculate discount for the provided cart.
     *
     * @param  CartManager  $cart  The cart manager instance
     * @return float  Calculated discount amount
     */
    public function calculate(CartManager $cart): float;
}
