<?php

declare(strict_types=1);

namespace App\ScheduleCalculation\UseCase\ReadModel;

interface VacationRepository
{
    /**
     * @param string $workerId
     * @return array<mixed>
     */
    public function findByWorkerId(string $workerId): array;
}
