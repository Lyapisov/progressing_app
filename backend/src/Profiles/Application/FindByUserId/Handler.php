<?php

declare(strict_types=1);

namespace App\Profiles\Application\FindByUserId;

use App\Profiles\Infrastructure\Repository\FanRepository;
use App\Profiles\Infrastructure\Repository\MusicianRepository;
use App\Profiles\Infrastructure\Repository\ProducerRepository;

final class Handler
{
    public function __construct(
        private FanRepository $fanRepository,
        private MusicianRepository $musicianRepository,
        private ProducerRepository $producerRepository,
    ) {
    }

    public function handle(Query $query): ReadModel
    {
        $fan = $this->fanRepository->findByUserId($query->getUserId());
        $musician = $this->musicianRepository->findByUserId($query->getUserId());
        $producer = $this->producerRepository->findByUserId($query->getUserId());

        $found = $fan || $musician || $producer;

        return new ReadModel(
            $found,
            !is_null($fan),
            !is_null($musician),
            !is_null($producer),
        );
    }
}
