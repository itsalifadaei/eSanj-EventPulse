<?php

namespace App\Contracts;

interface ErrorCodeInterface
{
    public function httpStatus(): int;

    public function message(array $params = []): string;
}
