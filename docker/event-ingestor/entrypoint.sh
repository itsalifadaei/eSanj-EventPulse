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

for i in $(seq 1 ${WAIT_TIMEOUT:-15}); do
    if nc -z "${CLICKHOUSE_HOST}" "${CLICKHOUSE_PORT}"; then
        echo "✅ Clickhouse is up!"

        sed -i "s|CLICKHOUSE_HOST=.*|CLICKHOUSE_HOST=${CLICKHOUSE_HOST}|" .env
        sed -i "s|CLICKHOUSE_PORT=.*|CLICKHOUSE_PORT=${CLICKHOUSE_PORT}|" .env
        sed -i "s|CLICKHOUSE_DATABASE=.*|CLICKHOUSE_DATABASE=${CLICKHOUSE_DATABASE}|" .env
        sed -i "s|CLICKHOUSE_USERNAME=.*|CLICKHOUSE_USERNAME=${CLICKHOUSE_USERNAME}|" .env
        sed -i "s|CLICKHOUSE_PASSWORD=.*|CLICKHOUSE_PASSWORD=${CLICKHOUSE_PASSWORD}|" .env


        echo "📦 Running ClickHouse Migrations..."
        php artisan migrate --force|| true

        break
    fi
    echo "⏳ Waiting for ClickHouse..."
    sleep 1
done


if ! nc -z "${CLICKHOUSE_HOST}" "${CLICKHOUSE_PORT}"; then
    echo "❌ Clickhouse not reachable after timeout!"
    exit 1
fi

echo "🚀 Executing the main CMD: $@"
exec "$@"