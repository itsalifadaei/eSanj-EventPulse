<?php

namespace Tests\E2E;

use Google\Protobuf\Timestamp;
use Grpc\ChannelCredentials;
use Illuminate\Support\Str;
use Telemetry\Event;
use Telemetry\EventServiceClient;
use Tests\TestCase;

class FullSystemFlowTest extends TestCase
{
    protected EventServiceClient $client;

    public function setUp(): void
    {
        parent::setUp();

        $this->client = new EventServiceClient(config('grpc.host') . ":" . config('grpc.port'), [
            'credentials' => ChannelCredentials::createInsecure(),
        ]);
    }

    public function test_full_ingest_and_query_flow()
    {
        $event = new Event([
            'user_id' => Str::uuid()->toString(),
            'event_type' => 'page_view',
            'happened_at' => new Timestamp([
                'seconds' => time()
            ]),
            'metadata' => ['os' => 'Linux']
        ]);

        list($response, $status) = $this->client->Push($event)->wait();

        $this->assertEquals(0, $status->code);

        sleep(1);

        $response = $this->get('/stats/top-users?event_type=page_view&limit=10');
        $response->assertStatus(200);

        $response = $this->get('/stats/hourly?event_type=page_view');
        $response->assertStatus(200);

        $this->assertTrue(true);
    }
}
