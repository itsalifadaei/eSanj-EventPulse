<?php

namespace App\Repositories;

use App\Contracts\Entities\Event;
use App\Models\Event as EventModel;

class EventRepository
{
    /**
     * Insert new event record
     */
    public function insertEvent(Event $event)
    {
       return EventModel::create((array)$event);
    }
}
