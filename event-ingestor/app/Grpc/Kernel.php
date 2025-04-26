<?php

namespace App\Grpc;


use App\Grpc\Contracts\EventServiceInterface;
use App\Grpc\Services\EventService;
use Spiral\RoadRunner\GRPC\Server;

class Kernel
{
    protected array $services = [
        EventServiceInterface::class => EventService::class,
    ];

    public function register(Server $server): void
    {
        foreach ($this->services as $interface => $implementation) {
            $server->registerService($interface, app()->make($implementation));
        }
    }
}
