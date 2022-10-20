<?php

namespace App\Tests\Helpers\Traits;

trait DIContainerTrait
{
    public function getDependency(string $dependencyName)
    {
        return self::$kernel
            ->getContainer()
            ->get($dependencyName)
            ;
    }
}
