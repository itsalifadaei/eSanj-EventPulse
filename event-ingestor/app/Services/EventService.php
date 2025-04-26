<?php

namespace App\Services;

use App\Contracts\Entities\Event;
use App\Repositories\EventRepository;

class EventService
{
    public function __construct(protected EventRepository $repository)
    {
    }

    public function ingest(Event $event)
    {
        return $this->repository->insertEvent($event);
    }
}
