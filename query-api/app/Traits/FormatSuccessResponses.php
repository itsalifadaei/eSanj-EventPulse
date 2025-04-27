<?php

namespace App\Traits;

use Illuminate\Http\JsonResponse;
use Symfony\Component\HttpFoundation\Response as SymfonyResponse;

trait FormatSuccessResponses
{
    public function responseSuccess(string $resource, $data = [], int $code = SymfonyResponse::HTTP_OK): JsonResponse
    {
        return response()->json([
            "status" => true,
            "data" => $resource::collection($data)
        ], $code);
    }
}
