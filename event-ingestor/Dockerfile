FROM phpswoole/swoole:6.0.1-php8.3

RUN apt update && apt install -y netcat-openbsd

RUN docker-php-ext-install sockets

WORKDIR /app

COPY event-ingestor/. ./

COPY --from=composer:2.6 /usr/bin/composer /usr/bin/

RUN composer install --optimize-autoloader --no-dev

RUN ./vendor/bin/rr get-binary

RUN mkdir -p storage/framework/cache storage/framework/sessions storage/framework/views storage/logs \
    && chmod -R 775 storage bootstrap/cache

COPY docker/event-ingestor/entrypoint.sh /usr/local/bin/entrypoint.sh

RUN chmod +x /usr/local/bin/entrypoint.sh

ENV APP_ENV=production
ENV APP_DEBUG=false

EXPOSE 9001

ENTRYPOINT ["entrypoint.sh"]

CMD ["./rr", "serve"]
