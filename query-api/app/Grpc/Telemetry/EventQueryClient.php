<?php
// GENERATED CODE -- DO NOT EDIT!

namespace Telemetry;

use Grpc\BaseStub;

/**
 * Client stub for EventService.
 */
class EventQueryClient extends BaseStub
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
     * GetHourlyStats
     *
     * @param \Telemetry\HourlyStatsRequest $argument
     * @param array $metadata
     * @param array $options
     *
     * @return \Grpc\UnaryCall
     */
    public function GetHourlyStats(\Telemetry\HourlyStatsRequest $argument,
                                                               $metadata = [], $options = [])
    {
        return $this->_simpleRequest(
            '/telemetry.EventQuery/GetHourlyStats',
            $argument,
            ['\Telemetry\HourlyStatsResponse', 'decode'],
            $metadata,
            $options
        );
    }

    /**
     * GetTopUsers
     *
     * @param \Telemetry\TopUsersRequest $argument
     * @param array $metadata
     * @param array $options
     *
     * @return \Grpc\UnaryCall
     */
    public function GetTopUsers(\Telemetry\TopUsersRequest $argument,
                                                           $metadata = [], $options = [])
    {
        return $this->_simpleRequest(
            '/telemetry.EventQuery/GetTopUsers',
            $argument,
            ['\Telemetry\TopUsersResponse', 'decode'],
            $metadata,
            $options
        );
    }
}
