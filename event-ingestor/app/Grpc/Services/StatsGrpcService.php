<?php

namespace App\Grpc\Services;

use App\Grpc\Contracts\StatsServiceInterface;
use App\Services\StatsService;
use Spiral\RoadRunner\GRPC\{ContextInterface, ServiceInterface};
use Telemetry\{HourlyStat, HourlyStatsRequest, HourlyStatsResponse, TopUsersRequest, TopUsersResponse, UserStat};


class StatsGrpcService implements StatsServiceInterface, ServiceInterface
{
    public function __construct(protected StatsService $statsService)
    {
    }

    public function GetHourlyStats(ContextInterface $ctx, HourlyStatsRequest $req): HourlyStatsResponse
    {
        $event_type = $req->getEventType();

        $statsRows = $this->statsService->getHourlyStats($event_type);

        $response = new HourlyStatsResponse();

        foreach ($statsRows as $row) {
            $hourStat = new HourlyStat();
            $hourStat->setCount($row['count']);
            $hourStat->setHappenedAt($row['date']);

            $response->getStats()[] = $hourStat;
        }

        return $response;
    }

    public function GetTopUsers(ContextInterface $ctx, TopUsersRequest $req): TopUsersResponse
    {
        $event_type = $req->getEventType();
        $limit = $req->getLimit();

        $statsRows = $this->statsService->getTopUsers($event_type, $limit);

        $response = new TopUsersResponse();

        foreach ($statsRows as $row) {
            $user = new UserStat();
            $user->setUserId($row['user_id']);
            $user->setEventCount($row['event_count']);

            $response->getUsers()[] = $user;
        }

        return $response;
    }
}
