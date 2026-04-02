<?php

use Obelaw\Basketin\Cart\Facades\Cart;
use Obelaw\Basketin\Cart\Delta\Tests\App\Carts\TestCart;
use Obelaw\Basketin\Cart\Delta\Tests\App\Models\Product;
use Obelaw\Basketin\Cart\Delta\Tests\App\Rules\TestRule;

beforeEach(function () {
    $this->product = Product::create([
        'name' => 'xBox',
        'sku' => 12345,
        'price' => 599,
    ]);
});

test('cart total with promotion applied via totals service', function () {
    $cart = Cart::make('01HF7V7N1MG9SDFPQYWXDNHR9Q', 'USD');
    $cart->quote()->addQuote($this->product, 1);

    $totals = $cart->totals();

    $totals->promotions()
        ->rule(new TestRule())
        ->apply();

    expect($totals->getGrandTotal())->toEqual(499);
});

test('cart total with promotion applied via cart manageTotals', function () {
    $cart = TestCart::make('01HF7V7N1MG9SDFPQYWXDNHR9Q', 'USD');
    $cart->quote()->addQuote($this->product, 1);

    $totals = $cart->totals();

    expect($totals->getGrandTotal())->toEqual(499);
});