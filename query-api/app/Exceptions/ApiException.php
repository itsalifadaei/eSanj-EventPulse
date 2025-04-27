<?php

namespace App\Exceptions;

use App\Contracts\ErrorCodeInterface;
use Illuminate\Http\Exceptions\HttpResponseException;


class ApiException extends HttpResponseException
{
    public function __construct(
        ErrorCodeInterface $code,
        ?string            $customMessage = null,
        ?int               $httpStatus = null,
        array              $params = []
    )
    {
        parent::__construct(response()->json([
            'status' => false,
            'message' => $customMessage ?? $code->message($params),
            'error_code' => $code->value,
        ], $httpStatus ?? $code->httpStatus()));
    }
}
