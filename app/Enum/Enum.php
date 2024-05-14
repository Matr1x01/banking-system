<?php
namespace App\Enum;

use ReflectionClass;

class Enum
{
    /**
     * Returns an array of the constants defined in the enum class.
     *
     * @return array
     */
    public static function toArray(): array
    {
        return (new ReflectionClass(static::class))->getConstants();
    }

    /**
     * Returns an associative array where the keys and values are the same as the constants' values.
     *
     * @return array
     */
    public static function toKeyedArray(): array
    {
        $constants = static::toArray();
        return array_combine($constants, $constants);
    }

    /**
     * Returns an array of the constants' values defined in the enum class.
     *
     * @return array
     */
    public static function cases(): array
    {
        return array_values(static::toArray());
    }
}
