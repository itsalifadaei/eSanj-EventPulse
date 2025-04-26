<?php

namespace App\Grpc\Services;

use App\Contracts\Entities\Event as EntitiesEvent;
use App\Grpc\Contracts\EventServiceInterface;
use App\Services\EventService as EventServices;
use Carbon\Carbon;
use Spiral\RoadRunner\GRPC\ContextInterface;
use Spiral\RoadRunner\GRPC\ServiceInterface;
use Telemetry\Event;
use Telemetry\EventPushResponse;


class EventService implements EventServiceInterface, ServiceInterface
{
    public function __construct(protected EventServices $service)
    {
    }

    public function Push(ContextInterface $ctx, Event $in): EventPushResponse
    {
        $event = new EntitiesEvent(
            user_id: $in->getUserId(),
            event_type: $in->getEventType(),
            happened_at: Carbon::createFromTimestamp($in->getHappenedAt()->getSeconds()),
            metadata: iterator_to_array($in->getMetadata()),
        );

        $this->service->ingest($event);

        $response = new EventPushResponse();
        $response->setSuccess(true);
        $response->setMessage("Event received successfully.");

        return $response;
    }
}
