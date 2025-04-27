<?php

namespace App\Repositories;

use App\Contracts\Entities\Event;
use App\Models\Event as EventModel;
use Illuminate\Database\Connection;
use Illuminate\Support\Facades\DB;


class EventRepository
{
    protected Connection $connection;

    public function __construct()
    {
        $this->connection = DB::connection("clickhouse");
    }

    /**
     * Insert new event record
     */
    public function insertEvent(Event $event): EventModel|false
    {
        return EventModel::create((array)$event);
    }

    /**
     * Get daily event statistics
     */
    public function getHourlyEvents(string $event_type = null): array
    {
        if ($event_type) {
            $event_type = "AND event_type = '$event_type'";
        }

        $sql = "WITH hours AS (SELECT toStartOfHour(now() - INTERVAL number HOUR) AS date FROM numbers(24))
        SELECT h.date, IFNULL(e.cnt, 0) AS count FROM hours AS h LEFT JOIN (SELECT toStartOfHour(happened_at) AS date,
        COUNT(*) AS cnt FROM events WHERE happened_at >= now() - INTERVAL 24 HOUR $event_type GROUP BY date) AS e
        ON h.date = e.date ORDER BY h.date DESC;";

        return $this->connection->select($sql);
    }

    public function getTopUsers(string $event_type, int $limit = 100): array
    {
        $type = $event_type ? "WHERE event_type = '$event_type'" : "";
        $sql = "SELECT user_id, COUNT(*) AS event_count FROM events $type GROUP BY user_id ORDER BY event_count DESC LIMIT $limit";

        return $this->connection->select($sql);
    }
}
