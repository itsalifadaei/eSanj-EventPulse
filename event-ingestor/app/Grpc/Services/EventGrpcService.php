<?php

namespace App\Grpc\Services;

use App\Contracts\Entities\Event as EntitiesEvent;
use App\Grpc\Contracts\EventServiceInterface;
use App\Services\EventService;
use Carbon\Carbon;
use Spiral\RoadRunner\GRPC\ContextInterface;
use Spiral\RoadRunner\GRPC\ServiceInterface;
use Telemetry\Event;
use Telemetry\EventPushResponse;


class EventGrpcService implements EventServiceInterface, ServiceInterface
{
    public function __construct(protected EventService $service)
    {
    }

    public function Push(ContextInterface $ctx, Event $req): EventPushResponse
    {
        $event = new EntitiesEvent(
            user_id: $req->getUserId(),
            event_type: $req->getEventType(),
            happened_at: Carbon::createFromTimestamp($req->getHappenedAt()->getSeconds()),
            metadata: iterator_to_array($req->getMetadata()),
        );

        $this->service->ingest($event);

        $response = new EventPushResponse();
        $response->setSuccess(true);
        $response->setMessage("Event received successfully.");

        return $response;
    }
}
