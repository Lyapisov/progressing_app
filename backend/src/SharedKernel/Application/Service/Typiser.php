<?php

namespace App\SharedKernel\Application\Service;

interface Typiser
{
    public function toString($value): string;
    public function toStringOrNull($value): ?string;
    public function toInt($value): int;
    public function toIntOrNull($value): ?int;
    public function toFloat($value, $precision = 2): float;
    public function toFloatOrNull($value, $precision = 2): ?float;
    public function toBool($value): bool;
}
