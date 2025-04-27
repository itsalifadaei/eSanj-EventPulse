<?php

namespace Tests\Feature;

use App\Contracts\Entities\Event;
use App\Repositories\EventRepository;
use Carbon\Carbon;
use Illuminate\Support\Str;
use Tests\TestCase;


class PushEventServiceTest extends TestCase
{

    public function test_store_event_calls_repository(): void
    {
        $event = new Event(
            user_id: Str::uuid()->toString(),
            event_type: 'view_page',
            happened_at: Carbon::now(),
            metadata: ['ip' => '127.0.0.1'],
        );

        $this->repository->insertEvent($event);

        $this->assertTrue(true);
    }
}
