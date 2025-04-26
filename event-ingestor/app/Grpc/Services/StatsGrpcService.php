<?php

namespace App\Grpc\Services;

use App\Grpc\Contracts\StatsServiceInterface;
use App\Services\StatsService;
use Spiral\RoadRunner\GRPC\{ContextInterface, ServiceInterface};
use Telemetry\HourlyStatsRequest;
use Telemetry\HourlyStatsResponse;
use Telemetry\TopUsersRequest;
use Telemetry\TopUsersResponse;

class StatsGrpcService implements StatsServiceInterface, ServiceInterface
{
    public function __construct(protected StatsService $statsService)
    {
    }

    public function GetHourlyStats(ContextInterface $ctx, HourlyStatsRequest $req): HourlyStatsResponse
    {
        return new HourlyStatsResponse();
    }

    public function GetTopUsers(ContextInterface $ctx, TopUsersRequest $req): TopUsersResponse
    {
        return new TopUsersResponse();
    }
}
