<?php

namespace App\Profiles\Test\Helpers;

use App\Profiles\Infrastructure\Repository\FanRepository;
use App\Profiles\Infrastructure\Repository\MusicianRepository;
use App\Profiles\Infrastructure\Repository\ProducerRepository;
use Symfony\Component\HttpKernel\KernelInterface;

trait ProfilesTrait
{
    /**
     * @var KernelInterface
     */
    protected static $kernel;

    private function getFanBuilder(): FanBuilder
    {
        return new FanBuilder();
    }

    private function getFanRepository(): FanRepository
    {
        /** @var FanRepository */
        $result = self::$kernel
            ->getContainer()
            ->get(FanRepository::class)
        ;
        return $result;
    }

    private function getMusicianRepository(): MusicianRepository
    {
        /** @var MusicianRepository */
        $result = self::$kernel
            ->getContainer()
            ->get(MusicianRepository::class)
        ;
        return $result;
    }

    private function getProducerRepository(): ProducerRepository
    {
        /** @var ProducerRepository */
        $result = self::$kernel
            ->getContainer()
            ->get(ProducerRepository::class)
        ;
        return $result;
    }
}
