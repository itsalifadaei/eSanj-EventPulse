FROM php:8.3-cli

RUN apt-get update && apt-get install -y \
    git unzip curl netcat-openbsd \
    libpq-dev libzip-dev libssl-dev libcurl4-openssl-dev \
    && docker-php-ext-install pdo pdo_mysql sockets

WORKDIR /app

COPY event-ingestor/. ./

COPY --from=composer:2.6 /usr/bin/composer /usr/bin/

RUN composer install --optimize-autoloader --no-dev

RUN ./vendor/bin/rr get-binary

RUN chmod -R 755 ./storage ./bootstrap/cache

COPY docker/event-ingestor/entrypoint.sh /usr/local/bin/entrypoint.sh

RUN chmod +x /usr/local/bin/entrypoint.sh

EXPOSE 9001

ENTRYPOINT ["entrypoint.sh"]

CMD ["./rr", "serve"]
