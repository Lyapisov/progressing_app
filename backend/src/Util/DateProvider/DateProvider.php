<?php


namespace App\Util\DateProvider;

use DateTimeImmutable;

interface DateProvider
{
    public function getNow(): DateTimeImmutable;
}
