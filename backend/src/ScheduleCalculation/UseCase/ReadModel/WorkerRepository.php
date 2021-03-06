<?php

declare(strict_types=1);

namespace App\ScheduleCalculation\UseCase\ReadModel;

interface WorkerRepository
{
    /**
     * @param string $workerId
     * @return array<mixed>
     */
    public function find(string $workerId): array;
}
