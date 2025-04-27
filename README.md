# EventPulse 🛰️

EventPulse is a lightweight microservices-based stack designed for real-time event ingestion, analytical storage, and
live dashboard visualization.

## Table of Contents

- [Architecture](#architecture)
- [Components](#components)
- [Getting Started](#getting-started)
- [Usage](#usage)
- [Rest API](#rest-api)

## Architecture

> A simple and fast system to collect user events, process them via gRPC, store in ClickHouse, and visualize key
> metrics.

Main services:

- **Event Ingestor** (gRPC server via Laravel Octane - Swoole)
- **Query API** (REST API consuming gRPC)
- **Frontend** (SPA - minimal dashboard)
- **ClickHouse** (Analytical DB)
- **Reverse Proxy** (Nginx)

Communication between services is **gRPC only**; databases are **not shared** directly.

## Components

### Event Ingestor (Laravel Octane)

- gRPC service implements `Push(Event)` (defined in [telemetry.proto](./protos/telemetry.proto)).
- ClickHouse storage via a MergeTree table.
- Fully SOLID-based service and repository architecture.

### Query API

- Provides `/stats/hourly?event_type=` and `/stats/top-users?event_type=&limit=`.
- Communicates with Event Ingestor via gRPC (not database directly).
- Exposed via REST (Laravel HTTP Controller).

### Frontend (SPA)

- Minimal single-page app using [Chart.js](https://www.chartjs.org/).
- Shows:
    - Bar chart: hourly event counts (last 24h)
    - Bar chart: top N users by event count
- Fetches updates every 5 seconds.

## Getting Started

Clone the repository:

```bash
git clone https://github.com/itsalifadaei/eSanj-EventPulse.git
cd eSanj-EventPulse
```

Start the environment:

```bash
docker compose up -d
```

Open the dashboard:

```
http://localhost:8080/
```

## Usage

### Push an Event (gRPC)

Example using `grpcurl`:

```bash
grpcurl -plaintext -d '{
  "user_id": "9a9ca3e7-5caf-4e67-9e44-53381d258890",
  "event_type": "view_page",
  "happened_at": {
    "seconds": 1745765187,
    "nanos": 10
  },
  "metadata": {
    "ip": "127.0.0.1"
  }
}' localhost:9001 telemetry.EventService/Push
```

## Rest API

### Get hourly stats:

```curl
curl "http://localhost:8080/stats/hourly?event_type=page_view"
```

### Get top users:

```curl
curl "http://localhost:8080/stats/top-users?event_type=page_view&limit=10"
```