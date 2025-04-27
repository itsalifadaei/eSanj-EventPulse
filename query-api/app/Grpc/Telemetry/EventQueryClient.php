<?php
// GENERATED CODE -- DO NOT EDIT!

namespace Telemetry;

use Grpc\BaseStub;

class EventQueryClient extends BaseStub
{
    /**
     * Constructor
     *
     * @param string $hostname
     * @param array $opts
     * @param \Grpc\Channel $channel (optional)
     */
    public function __construct($hostname, $opts = [], $channel = null)
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
