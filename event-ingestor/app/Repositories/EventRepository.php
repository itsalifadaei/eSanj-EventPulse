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
    public function getDailyEvents(string $event_type): array
    {
        $sql = "WITH dates AS (SELECT today() - INTERVAL number DAY AS date FROM numbers(30))
                SELECT d.date, SUM(e.event_exists) AS count
                FROM dates d LEFT JOIN (SELECT toDate(happened_at) AS date, 1 AS event_exists
                FROM events WHERE event_type = '$event_type') e ON e.date = d.date
               GROUP BY d.date ORDER BY d.date DESC;";

        return $this->connection->select($sql);
    }

    public function getTopUsers(string $event_type, int $limit = 100): array
    {
        $sql = "SELECT user_id, COUNT(*) AS event_count FROM events WHERE event_type = '$event_type' GROUP BY user_id ORDER BY event_count DESC LIMIT $limit";

        return $this->connection->select($sql);
    }
}
