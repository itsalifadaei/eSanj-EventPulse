<?php
// GENERATED CODE -- DO NOT EDIT!

namespace Telemetry;

use Grpc\BaseStub;

/**
 * Client stub for EventService.
 */
class EventServiceClient extends BaseStub
{
    /**
     * @param string $hostname hostname
     * @param array $opts channel options
     * @param \Grpc\Channel|null $channel (optional) re-use existing channel
     */
    public function __construct(string $hostname, array $opts = [], ?\Grpc\Channel $channel = null)
    {
        parent::__construct($hostname, $opts, $channel);
    }

    /**
     * @param \Telemetry\Event $argument input argument
     * @param array $metadata metadata
     * @param array $options call options
     *
     * @return \Grpc\UnaryCall
     */
    public function Push(\Telemetry\Event $argument, array $metadata = [], array $options = [])
    {
        return $this->_simpleRequest(
            '/telemetry.EventService/Push',
            $argument,
            ['\Telemetry\EventPushResponse', 'decode'],
            $metadata,
            $options
        );
    }
}
