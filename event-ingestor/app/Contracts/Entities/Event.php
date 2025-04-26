<?php

namespace App\Contracts\Entities;

use Carbon\Carbon;

class Event
{
    public function __construct(
        public string $user_id,
        public string $event_type,
        public Carbon $happened_at,
        public array  $metadata = []
    )
    {
    }
}
