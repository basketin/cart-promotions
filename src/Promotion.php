<?php

namespace Obelaw\Basketin\Cart\Promotions;

abstract class Promotion
{
    protected ?string $name = null;

    public function getName(): string
    {
        return $this->name ?? static::class;
    }
}
