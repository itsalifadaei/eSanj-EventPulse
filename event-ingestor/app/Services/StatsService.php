<?php

namespace App\Services;

use App\Enums\EventTypeEnum;
use App\Repositories\EventRepository;

class StatsService
{
    public function __construct(protected EventRepository $eventRepository)
    {
    }

    public function getDailyStats(string $type): array
    {
        $type = EventTypeEnum::getType($type);

        return $this->eventRepository->getDailyEvents($type);
    }

    public function getTopUsers(string $type, int $limit = 100): array
    {
        $type = EventTypeEnum::getType($type);

        return $this->eventRepository->getTopUsers($type, $limit);
    }
}
