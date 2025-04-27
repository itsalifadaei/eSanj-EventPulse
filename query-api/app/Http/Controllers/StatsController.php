<?php

namespace App\Http\Controllers;

use App\Enums\BaseErrorEnum;
use App\Http\Requests\HourlyStatsRequest;
use App\Http\Requests\TopUserStatsRequest;
use App\Http\Resources\HourlyStatsResponce;
use App\Http\Resources\TopUserStatsResource;
use App\Services\StatsService;
use App\Traits\FormatErrorResponses;
use App\Traits\FormatSuccessResponses;
use Exception;
use Illuminate\Http\JsonResponse;


class StatsController extends Controller
{
    use FormatSuccessResponses, FormatErrorResponses;


    public function __construct(protected StatsService $statsService)
    {
    }

    public function getTopUsersStats(TopUserStatsRequest $request): JsonResponse
    {
        try {
            $data = $this->statsService->getTopUsers($request->input("event_type"), $request->input("limit", 100));
        } catch (Exception $e) {
            return $this->errorResponse(BaseErrorEnum::SERVER_ERROR);
        }

        return $this->responseSuccess(TopUserStatsResource::class, collect($data));
    }

    public function getHourlyStats(HourlyStatsRequest $request): JsonResponse
    {
        try {
            $data = $this->statsService->getHourlyStats($request->input("event_type"));
        }catch (Exception $e) {
            return $this->errorResponse(BaseErrorEnum::SERVER_ERROR);
        }


        return $this->responseSuccess(HourlyStatsResponce::class, collect($data));
    }
}
