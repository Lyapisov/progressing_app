<?php


namespace App\Profiles\Test\Helpers;


use App\Profiles\Infrastructure\Repository\FanRepository;
use App\Profiles\Infrastructure\Repository\MusicianRepository;
use App\Profiles\Infrastructure\Repository\Read\FanReadRepository;
use Symfony\Component\HttpKernel\KernelInterface;

trait ProfilesTrait
{
    /**
     * @var KernelInterface
     */
    protected static $kernel;

    private function getFanReadRepository(): FanReadRepository
    {
        /** @var FanReadRepository */
        $result = self::$kernel
            ->getContainer()
            ->get(FanReadRepository::class)
        ;
        return $result;
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
}
