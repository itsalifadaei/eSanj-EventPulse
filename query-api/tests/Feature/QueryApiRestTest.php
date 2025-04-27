<?php

namespace Tests\Feature;

use Tests\TestCase;

class QueryApiRestTest extends TestCase
{
    public function test_hourly_stats_endpoint()
    {
        $response = $this->get('/stats/hourly?event_type=page_view');

        $response->assertStatus(200);
        $response->assertJsonStructure([
            'data' => [
                '*' => ['date', 'count']
            ]
        ]);
    }

    public function test_top_users_endpoint()
    {
        $response = $this->get('/stats/top-users?event_type=purchase&limit=5');

        $response->assertStatus(200);
        $response->assertJsonStructure([
            'data' => [
                '*' => ['user_id', 'count']
            ]
        ]);
    }
}
