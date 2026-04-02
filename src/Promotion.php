<?php

namespace Obelaw\Basketin\Cart\Delta;

use Closure;
use Obelaw\Basketin\Cart\Delta\Enums\Priority;

abstract class Promotion
{
    protected ?string $name = null;
    protected Priority $priority = Priority::MEDIUM;
    protected array $excludes = [];

    public function getName(): string
    {
        return $this->name ?? static::class;
    }

    public function getPriority(): Priority
    {
        return $this->priority;
    }

    public function setPriority(Priority $priority): self
    {
        $this->priority = $priority;

        return $this;
    }

    public function getExcludes(): array
    {
        return $this->excludes;
    }

    public function applying(DeltaContext $context): bool
    {
        foreach ($this->getExcludes() as $excludedClass) {
            if ($context->hasApplied($excludedClass)) {
                return false;
            }
        }

        return true;
    }

    abstract public function calculate(DeltaContext $context): float;

    public function handle(DeltaContext $context, Closure $next)
    {
        if (!$this->applying($context)) {
            return $next($context);
        }

        $discount = $this->calculate($context);

        if ($discount > 0) {
            $context->applyDiscount($discount, $this->getName());
        }

        return $next($context);
    }
}
