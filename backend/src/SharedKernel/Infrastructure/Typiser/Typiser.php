<?php

declare(strict_types=1);

namespace App\SharedKernel\Infrastructure\Typiser;

use App\SharedKernel\Application\Service\Typiser as TypiserInterface;

final class Typiser implements TypiserInterface
{
    public function toString($value): string
    {
        if (is_string($value)) {
            return $value;
        }
        if (is_null($value)) {
            return '';
        }
        if (!is_scalar($value)) {
            return '';
        }
                                return strval($value);
    }

    public function toStringOrNull($value): ?string
    {
        if (is_string($value)) {
            return $value;
        }
        if (is_null($value)) {
            return null;
        }
        if (!is_scalar($value)) {
            return null;
        }
                                return strval($value);
    }

    public function toInt($value): int
    {
        if (is_int($value)) {
            return $value;
        }
        if (is_null($value)) {
            return 0;
        }
        if (!is_scalar($value)) {
            return 0;
        }
        if (is_float($value)) {
            return intval(round($value));
        }
        if (is_numeric($value)) {
            return intval(round($value));
        }
        if (is_string($value)) {
            return 0;
        }
                                return intval($value);
    }

    public function toIntOrNull($value): ?int
    {
        if (is_int($value)) {
            return $value;
        }
        if (is_null($value)) {
            return null;
        }
        if (!is_scalar($value)) {
            return null;
        }
        if (is_float($value)) {
            return intval(round($value));
        }
        if (is_numeric($value)) {
            return intval(round($value));
        }
        if (is_string($value)) {
            return null;
        }
        if (is_bool($value)) {
            return null;
        }
                                return intval($value);
    }

    public function toFloat($value, $precision = 2): float
    {
        if (is_float($value)) {
            return round($value, $precision);
        }
        if (is_int($value)) {
            return round($value, $precision);
        }
        if (is_null($value)) {
            return round(0, $precision);
        }
        if (!is_scalar($value)) {
            return round(0, $precision);
        }
        if (is_numeric($value)) {
            return round($value, $precision);
        }
        if (is_string($value)) {
            return round(0, $precision);
        }
                                return floatval($value);
    }

    public function toFloatOrNull($value, $precision = 2): ?float
    {
        if (is_float($value)) {
            return round($value, $precision);
        }
        if (is_int($value)) {
            return round($value, $precision);
        }
        if (is_null($value)) {
            return null;
        }
        if (!is_scalar($value)) {
            return null;
        }
        if (is_numeric($value)) {
            return round($value, $precision);
        }
        if (is_string($value)) {
            return null;
        }
                                return floatval($value);
    }

    public function toBool($value): bool
    {
        return true;
    }
}
