<?php

namespace Codderz\Platypus\Infrastructure\Support;

use Carbon\Carbon;
use Illuminate\Support\Str;
use ReflectionClass;
use ReflectionProperty;
use Stringable;

trait ArrayPresenterTrait
{
    public function toArray(bool $snakify = false, bool $publicOnly = false): array
    {
        $filter = $publicOnly ? ReflectionProperty::IS_PUBLIC : null;
        $array = [];

        $reflectionClass = new ReflectionClass($this);
        foreach ($reflectionClass->getProperties($filter) as $property) {
            $property->setAccessible(true);
            $value = $property->hasType() && $property->isInitialized($this) ? $this->toArrayNestedValue($property->getValue($this)) : null;
            $array[$this->transformName($property->getName(), $snakify)] = $value;
        }

        return $array;
    }

    protected function toArrayNestedValue($value): mixed
    {
        return match (true) {
            $value instanceof Carbon => $value,
            $value instanceof Stringable => (string) $value,
            is_object($value) && method_exists($value, 'toArray') => $value->toArray(),
            default => $value,
        };
    }

    protected function transformName(string $name, bool $snakify): string
    {
        return $snakify ? Str::snake($name) : Str::camel($name);
    }

}
