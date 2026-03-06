<?php

use Obelaw\Basketin\Cart\Facades\CartManagement;
use Obelaw\Basketin\Cart\Promotions\Tests\App\Models\Product;

test('cart total without promotions', function () {
    $product = Product::create([
        'name' => 'iPhone',
        'sku' => 11111,
        'price' => 1000,
    ]);

    $cart = CartManagement::make('01HF7V7N1MG9SDFPQYWXDNHR9Q', 'USD');
    $cart->quote()->addQuote($product, 2);

    $totals = $cart->totals();

    expect($totals->getSubtotal())->toEqual(2000);
    expect($totals->getGrandTotal())->toEqual(2000);
});

test('cart total with one promotion', function () {
    $product = Product::create([
        'name' => 'MacBook',
        'sku' => 22222,
        'price' => 1500,
    ]);

    $cart = CartManagement::make('01HF7V7N1MG9SDFPQYWXDNHR9Q', 'USD');
    $cart->quote()->addQuote($product, 1);

    $totals = $cart->totals();

    $totals->promotions()
        ->rule(new \Obelaw\Basketin\Cart\Promotions\Tests\App\Rules\TestRule())
        ->apply();

    expect($totals->getSubtotal())->toEqual(1500);
    expect($totals->getGrandTotal())->toEqual(1400);
});

test('multiple promotions applied to cart', function () {
    $product = Product::create([
        'name' => 'iPad',
        'sku' => 33333,
        'price' => 800,
    ]);

    $cart = CartManagement::make('01HF7V7N1MG9SDFPQYWXDNHR9Q', 'USD');
    $cart->quote()->addQuote($product, 1);

    $totals = $cart->totals();

    $totals->promotions()
        ->rule(new \Obelaw\Basketin\Cart\Promotions\Tests\App\Rules\TestRule())
        ->rule(new \Obelaw\Basketin\Cart\Promotions\Tests\App\Rules\TestRule())
        ->apply();

    expect($totals->getSubtotal())->toEqual(800);
    expect($totals->getGrandTotal())->toEqual(600);
});

test('promotion with zero discount does not apply', function () {
    $product = Product::create([
        'name' => 'Watch',
        'sku' => 44444,
        'price' => 500,
    ]);

    $cart = CartManagement::make('01HF7V7N1MG9SDFPQYWXDNHR9Q', 'USD');
    $cart->quote()->addQuote($product, 1);

    $totals = $cart->totals();

    $totals->promotions()
        ->rule(new \Obelaw\Basketin\Cart\Promotions\Tests\App\Rules\ZeroDiscountRule())
        ->apply();

    expect($totals->getSubtotal())->toEqual(500);
    expect($totals->getGrandTotal())->toEqual(500);
});

test('promotions applied rules tracking', function () {
    $product = Product::create([
        'name' => 'AirPods',
        'sku' => 55555,
        'price' => 200,
    ]);

    $cart = CartManagement::make('01HF7V7N1MG9SDFPQYWXDNHR9Q', 'USD');
    $cart->quote()->addQuote($product, 1);

    $totals = $cart->totals();

    $engine = $totals->promotions()
        ->rule(new \Obelaw\Basketin\Cart\Promotions\Tests\App\Rules\TestRule())
        ->apply();

    $appliedRules = $engine->getAppliedRules();

    expect($appliedRules)->toHaveCount(1);
    expect($appliedRules[0]['name'])->toEqual('test rule');
    expect($appliedRules[0]['discount_amount'])->toEqual(100);
});

test('multiple promotions applied rules tracking', function () {
    $product = Product::create([
        'name' => 'Display',
        'sku' => 66666,
        'price' => 400,
    ]);

    $cart = CartManagement::make('01HF7V7N1MG9SDFPQYWXDNHR9Q', 'USD');
    $cart->quote()->addQuote($product, 1);

    $totals = $cart->totals();

    $engine = $totals->promotions()
        ->rule(new \Obelaw\Basketin\Cart\Promotions\Tests\App\Rules\TestRule())
        ->rule(new \Obelaw\Basketin\Cart\Promotions\Tests\App\Rules\AnotherRule())
        ->apply();

    $appliedRules = $engine->getAppliedRules();

    expect($appliedRules)->toHaveCount(2);
    expect($appliedRules[0]['name'])->toEqual('test rule');
    expect($appliedRules[1]['name'])->toEqual('another rule');
});
