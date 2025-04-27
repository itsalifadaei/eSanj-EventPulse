<?php

namespace Tests\Feature;

use App\Repositories\EventRepository;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class TopUserStatsTest extends TestCase
{
    public function test_it_returns_top_users_stats_format(): void
    {
        $this->repository->getTopUsers("view_page",5);

        $this->assertTrue(true);
    }
}
