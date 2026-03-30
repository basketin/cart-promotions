<?php

use Obelaw\Basketin\Cart\Promotions\DiscountContext;
use Obelaw\Basketin\Cart\Promotions\Promotion;
use Obelaw\Basketin\Cart\Promotions\PromotionEngine;

beforeEach(function () {
    $this->cart = Mockery::mock(\Obelaw\Basketin\Cart\Services\CartManager::class);
    $this->totals = Mockery::mock(\Obelaw\Basketin\Cart\Services\TotalManager::class)->makePartial();

    $this->totals->shouldReceive('applyDiscount')->andReturnUsing(function ($amount, $name) {
        return $this->totals;
    });

    $this->totals->shouldReceive('getCartService')->andReturn($this->cart);
    $this->totals->shouldReceive('getSubtotal')->andReturn(1000);
});

afterEach(function () {
    Mockery::close();
});

test('promotion returns class name when no name is set', function () {
    $promotion = new class extends Promotion {
        public function calculate(DiscountContext $context): float
        {
            return 0;
        }
    };

    expect($promotion->getName())->toBeString();
    expect($promotion->getName())->not->toBeEmpty();
});

test('promotion returns custom name when set', function () {
    $promotion = new class extends Promotion {
        protected ?string $name = 'Custom Promotion';

        public function calculate(DiscountContext $context): float
        {
            return 0;
        }
    };

    expect($promotion->getName())->toEqual('Custom Promotion');
});

test('promotion engine adds rule', function () {
    $engine = new PromotionEngine($this->cart, $this->totals);

    $rule = Mockery::mock(\Obelaw\Basketin\Cart\Promotions\Contracts\PromotionRule::class);
    $rule->shouldReceive('getName')->andReturn('Test Rule');

    $engine->rule($rule);

    expect($engine->getAppliedRules())->toBeArray();
});

test('promotion engine applies rule and calculates discount', function () {
    $engine = new PromotionEngine($this->cart, $this->totals);

    $rule = Mockery::mock(\Obelaw\Basketin\Cart\Promotions\Contracts\PromotionRule::class);
    $rule->shouldReceive('getName')->andReturn('Test Rule');
    $rule->shouldReceive('calculate')->withAnyArgs()->andReturn(100);
    $rule->shouldReceive('handle')->andReturnUsing(function ($context, $next) use ($rule) {
        $discount = $rule->calculate($context);
        if ($discount > 0) {
            $context->applyDiscount($discount, $rule->getName());
        }
        return $next($context);
    });

    $engine->rule($rule);
    $result = $engine->apply();

    expect($result)->toBeInstanceOf(PromotionEngine::class);
    expect($engine->getAppliedRules())->toHaveCount(1);
    expect($engine->getAppliedRules()[0]['name'])->toEqual('Test Rule');
    expect($engine->getAppliedRules()[0]['discount_amount'])->toEqual(100);
});

test('promotion engine does not apply zero discount', function () {
    $engine = new PromotionEngine($this->cart, $this->totals);

    $rule = Mockery::mock(\Obelaw\Basketin\Cart\Promotions\Contracts\PromotionRule::class);
    $rule->shouldReceive('getName')->andReturn('Zero Discount Rule');
    $rule->shouldReceive('handle')->andReturnUsing(function ($context, $next) {
        return $next($context);
    });

    $engine->rule($rule);
    $engine->apply();

    expect($engine->getAppliedRules())->toHaveCount(0);
});

test('promotion engine applies multiple rules', function () {
    $engine = new PromotionEngine($this->cart, $this->totals);

    $rule1 = Mockery::mock(\Obelaw\Basketin\Cart\Promotions\Contracts\PromotionRule::class);
    $rule1->shouldReceive('getName')->andReturn('Rule One');
    $rule1->shouldReceive('handle')->andReturnUsing(function ($context, $next) use ($rule1) {
        $context->applyDiscount(50, $rule1->getName());
        return $next($context);
    });

    $rule2 = Mockery::mock(\Obelaw\Basketin\Cart\Promotions\Contracts\PromotionRule::class);
    $rule2->shouldReceive('getName')->andReturn('Rule Two');
    $rule2->shouldReceive('handle')->andReturnUsing(function ($context, $next) use ($rule2) {
        $context->applyDiscount(30, $rule2->getName());
        return $next($context);
    });

    $engine->rule($rule1);
    $engine->rule($rule2);
    $engine->apply();

    expect($engine->getAppliedRules())->toHaveCount(2);
    expect($engine->getAppliedRules()[0]['name'])->toEqual('Rule One');
    expect($engine->getAppliedRules()[1]['name'])->toEqual('Rule Two');
});

test('promotion engine resets applied rules on each apply', function () {
    $engine = new PromotionEngine($this->cart, $this->totals);

    $rule = Mockery::mock(\Obelaw\Basketin\Cart\Promotions\Contracts\PromotionRule::class);
    $rule->shouldReceive('getName')->andReturn('Test Rule');
    $rule->shouldReceive('handle')->andReturnUsing(function ($context, $next) use ($rule) {
        $context->applyDiscount(100, $rule->getName());
        return $next($context);
    });

    $engine->rule($rule);
    $engine->apply();

    expect($engine->getAppliedRules())->toHaveCount(1);

    $engine->apply();

    expect($engine->getAppliedRules())->toHaveCount(1);
});

test('promotion engine uses cart totals when not provided', function () {
    $this->cart->shouldReceive('totals')->andReturn($this->totals);

    $engine = new PromotionEngine($this->cart);

    expect($engine)->toBeInstanceOf(PromotionEngine::class);
});
