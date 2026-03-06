<?php

use Obelaw\Basketin\Cart\Facades\CartManagement;
use Obelaw\Basketin\Cart\Promotions\Tests\App\Carts\TestCart;
use Obelaw\Basketin\Cart\Promotions\Tests\App\Models\Product;
use Obelaw\Basketin\Cart\Promotions\Tests\App\Rules\TestRule;

beforeEach(function () {
    $this->product = Product::create([
        'name' => 'xBox',
        'sku' => 12345,
        'price' => 599,
    ]);
});

test('Get Item Final Total', function () {
    $cart = CartManagement::make('01HF7V7N1MG9SDFPQYWXDNHR9Q', 'USD');
    $cart->quote()->addQuote($this->product, 1);

    $totals = $cart->totals();

    $totals->promotions()
        ->rule(new TestRule())
        ->apply();

    expect($totals->getGrandTotal())->toEqual(499);
});

test('Cart class', function () {
    $cart = TestCart::make('01HF7V7N1MG9SDFPQYWXDNHR9Q', 'USD');
    $cart->quote()->addQuote($this->product, 1);

    $totals = $cart->totals();

    expect($totals->getGrandTotal())->toEqual(499);
});