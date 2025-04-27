#!/bin/bash

set -e

echo '🚀 [ENTRYPOINT] Starting up...'

if [ ! -f .env ]; then
    echo "⚡ .env not found. Creating from .env.example..."
    cp .env.example .env
fi

if ! grep -q '^APP_KEY=' .env || [ "$(grep '^APP_KEY=' .env | cut -d '=' -f2)" == "" ]; then
  echo "🔐 Generating APP_KEY..."
  php artisan key:generate
fi

echo "💬 Waiting for Clickhouse to be up (${CLICKHOUSE_HOST}:${CLICKHOUSE_PORT}) ..."

for i in $(seq 1 ${WAIT_TIMEOUT:-30}); do
    if nc -z "${CLICKHOUSE_HOST}" "${CLICKHOUSE_PORT}"; then
        echo "✅ Clickhouse is up!"

        echo "📦 Running ClickHouse Migrations..."
        php artisan migrate --force|| true

        break
    fi
    echo "⏳ Waiting for ClickHouse..."
    sleep 5
done


if ! nc -z "${CLICKHOUSE_HOST}" "${CLICKHOUSE_PORT}"; then
    echo "❌ Clickhouse not reachable after timeout!"
    exit 1
fi

echo "🚀 Executing the main CMD: $@"
exec "$@"