<?php

namespace App\Tests\Helpers\Traits\Publications;

use App\Publications\Infrastructure\Repositories\AuthorRepository;
use App\Publications\Infrastructure\Repositories\PublicationRepository;
use App\Tests\Helpers\Builders\Publications\AuthorBuilder;
use App\Tests\Helpers\Builders\Publications\PublicationBuilder;
use Symfony\Component\HttpKernel\KernelInterface;

trait PublicationsTrait
{
    /**
     * @var KernelInterface
     */
    protected static $kernel;

    private function getAuthorBuilder(): AuthorBuilder
    {
        return new AuthorBuilder();
    }

    private function getPublicationBuilder(): PublicationBuilder
    {
        return new PublicationBuilder();
    }

    private function getAuthorRepository(): AuthorRepository
    {
        /** @var AuthorRepository */
        $result = self::$kernel
            ->getContainer()
            ->get(AuthorRepository::class)
        ;
        return $result;
    }

    private function getPublicationRepository(): PublicationRepository
    {
        /** @var PublicationRepository */
        $result = self::$kernel
            ->getContainer()
            ->get(PublicationRepository::class)
        ;
        return $result;
    }
}
