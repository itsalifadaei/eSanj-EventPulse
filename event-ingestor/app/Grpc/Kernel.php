<?php

namespace App\Grpc;

use App\Grpc\Contracts\{EventServiceInterface, StatsServiceInterface};
use App\Grpc\Services\{EventGrpcService, StatsGrpcService};
use Spiral\RoadRunner\GRPC\Server;

class Kernel
{
    protected array $services = [
        EventServiceInterface::class => EventGrpcService::class,
        StatsServiceInterface::class => StatsGrpcService::class,
    ];

    public function register(Server $server): void
    {
        foreach ($this->services as $interface => $implementation) {
            $server->registerService($interface, app()->make($implementation));
        }
    }
}
