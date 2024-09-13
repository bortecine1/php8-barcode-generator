<?php

declare(strict_types = 1);

namespace Barcode\Types;

abstract class OrientationType
{
    public const HORIZONTAL = 0;
    public const VERTICAL   = 1;

    public static function isValidValue(mixed $value): bool
    {
        $reflect   = new \ReflectionClass(static::class);
        $constants = $reflect->getConstants();

        return \in_array($value, $constants, true);
    }
}