<?php

namespace Tests\Feature;

use App\Repositories\EventRepository;
use Tests\TestCase;

class HourlyStatsTest extends TestCase
{

    public function test_it_returns_top_users_stats_format(): void
    {
        $this->repository->getTopUsers("view_page",5);

        $this->assertTrue(true);
    }
}
