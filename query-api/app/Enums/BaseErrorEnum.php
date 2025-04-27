<?php

namespace App\Enums;


use App\Contracts\ErrorCodeInterface;
use Symfony\Component\HttpFoundation\Response;


enum BaseErrorEnum: string implements ErrorCodeInterface
{
    case SERVER_ERROR = 'server_error';

    public function httpStatus(): int
    {
        return match ($this) {
            self::SERVER_ERROR => Response::HTTP_INTERNAL_SERVER_ERROR,
        };
    }

    public function message(array $params = []): string
    {
        return trans("messages.errors.{$this->value}", $params);
    }
}
