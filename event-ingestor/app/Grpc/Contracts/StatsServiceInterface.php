<?php

namespace App\Grpc\Contracts;

use Spiral\RoadRunner\GRPC\ContextInterface;
use Telemetry\{DailyStatsRequest, DailyStatsResponse, TopUsersRequest, TopUsersResponse};

interface StatsServiceInterface
{
    const NAME = "telemetry.EventQuery";

    public function GetDailyStats(ContextInterface $ctx, DailyStatsRequest $req): DailyStatsResponse;

    public function GetTopUsers(ContextInterface $ctx, TopUsersRequest $req): TopUsersResponse;
}
