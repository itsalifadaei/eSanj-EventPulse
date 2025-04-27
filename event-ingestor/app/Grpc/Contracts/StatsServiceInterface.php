<?php

namespace App\Grpc\Contracts;

use Spiral\RoadRunner\GRPC\ContextInterface;
use Telemetry\{HourlyStatsRequest, HourlyStatsResponse, TopUsersRequest, TopUsersResponse};

interface StatsServiceInterface
{
    const NAME = "telemetry.EventQuery";

    public function GetHourlyStats(ContextInterface $ctx, HourlyStatsRequest $req): HourlyStatsResponse;

    public function GetTopUsers(ContextInterface $ctx, TopUsersRequest $req): TopUsersResponse;
}
