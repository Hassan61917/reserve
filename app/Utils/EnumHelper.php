<?php

namespace App\Utils;

use Exception;
use ReflectionEnum;

class EnumHelper
{
    public static function getConstants(string $enum): array
    {
        try {
            $reflector = new ReflectionEnum($enum);
            return $reflector->getConstants();
        } catch (Exception) {
            return [];
        }
    }
    public static function toArray(string $enum): array
    {
        $constants = static::getConstants($enum);
        return array_keys($constants);
    }
    public static function getValue(string $enum, string $key): mixed
    {
        return static::getConstants($enum)[$key] ?? null;
    }
}
