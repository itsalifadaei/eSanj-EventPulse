<?php

namespace App\Grpc\Contracts;

use Spiral\RoadRunner\GRPC\ContextInterface;
use Telemetry\HourlyStatsRequest;
use Telemetry\HourlyStatsResponse;
use Telemetry\TopUsersRequest;
use Telemetry\TopUsersResponse;

interface StatsServiceInterface
{
    const NAME = "telemetry.EventQuery";

    public function GetHourlyStats(ContextInterface $ctx, HourlyStatsRequest $req): HourlyStatsResponse;

    public function GetTopUsers(ContextInterface $ctx, TopUsersRequest $req): TopUsersResponse;
}
