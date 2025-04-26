<?php

namespace App\Grpc\Contracts;

use Spiral\RoadRunner\GRPC\ContextInterface;
use Telemetry\Event;
use Telemetry\EventPushResponse;

interface EventServiceInterface
{
    const NAME = "telemetry.EventService";
    public function Push(ContextInterface $ctx, Event $in): EventPushResponse;
}
