<?php

namespace App\Traits;

use App\Contracts\ErrorCodeInterface;
use App\Exceptions\ApiException;
use Illuminate\Http\JsonResponse;


trait FormatErrorResponses
{
    public function errorResponse(
        ErrorCodeInterface $code,
        ?string            $message = null,
        ?int               $status = null,
        array              $params = []
    ): JsonResponse
    {
        throw new ApiException($code, $message, $status, $params);
    }
}
