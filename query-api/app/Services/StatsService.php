<?php

namespace App\Services;

use Exception;
use Grpc\ChannelCredentials;
use Telemetry\EventQueryClient;
use Telemetry\HourlyStatsRequest;
use Telemetry\TopUsersRequest;
use const Grpc\CALL_OK;

class StatsService
{
    private $client;

    public function __construct()
    {
        $this->client = new EventQueryClient(config('grpc.host') . ":" . config('grpc.port'), [
            'credentials' => ChannelCredentials::createInsecure(),
        ]);
    }

    public function getTopUsers(string $type = null, int $limit = 100)
    {
        $req = new TopUsersRequest();
        $req->setLimit($limit);
        $req->setEventType($type);

        list($response, $status) = $this->client->GetTopUsers($req)->wait();

        if ($status->code === CALL_OK) {
            return $response->getUsers();
        } else {
            throw new Exception('gRPC failed: ' . $status->details);
        }
    }

    public function getHourlyStats(string $type = null)
    {
        $req = new HourlyStatsRequest();
        $req->setEventType($type);

        list($response, $status) = $this->client->GetHourlyStats($req)->wait();

        if ($status->code === CALL_OK) {
            return $response->getStats();
        } else {
            throw new Exception('gRPC failed: ' . $status->details);
        }
    }
}
