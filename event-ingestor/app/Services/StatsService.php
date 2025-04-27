<?php

namespace App\Services;

use App\Enums\EventTypeEnum;
use App\Repositories\EventRepository;

class StatsService
{
    public function __construct(protected EventRepository $eventRepository)
    {
    }

    public function getHourlyStats(string $type = null): array
    {
        $type = EventTypeEnum::getType($type);

        return $this->eventRepository->getHourlyEvents($type);
    }

    public function getTopUsers(string $type = null, int $limit = 100): array
    {
        $type = EventTypeEnum::getType($type);

        return $this->eventRepository->getTopUsers($type, $limit);
    }
}
