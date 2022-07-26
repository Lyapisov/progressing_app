<?php

namespace App\Tests\Helpers\Traits\Publications;

use App\Publications\Infrastructure\Repositories\AuthorRepository;
use Symfony\Component\HttpKernel\KernelInterface;

trait PublicationsTrait
{
    /**
     * @var KernelInterface
     */
    protected static $kernel;

    private function getAuthorRepository(): AuthorRepository
    {
        /** @var AuthorRepository */
        $result = self::$kernel
            ->getContainer()
            ->get(AuthorRepository::class)
        ;
        return $result;
    }
}
