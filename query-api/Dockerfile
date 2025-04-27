FROM phpswoole/swoole:6.0.1-php8.3

WORKDIR /app

COPY --from=ghcr.io/redfieldchristabel/php_grpc:8.3 /usr/local/lib/php/extensions/ /usr/local/lib/php/extensions/

COPY --from=ghcr.io/redfieldchristabel/php_grpc:8.3 /usr/local/etc/php/conf.d/docker-php-ext-grpc.ini /usr/local/etc/php/conf.d/docker-php-ext-grpc.ini

RUN pecl install protobuf && docker-php-ext-enable grpc protobuf

COPY --from=composer:2.7 /usr/bin/composer /usr/bin/composer

COPY query-api/. .

RUN composer install --no-dev --optimize-autoloader

RUN mkdir -p storage/framework/cache storage/framework/sessions storage/framework/views storage/logs \
    && chmod -R 775 storage bootstrap/cache

RUN docker-php-ext-install pcntl

ENV APP_ENV=production
ENV APP_DEBUG=true

EXPOSE 8000

CMD ["php", "artisan", "octane:start", "--server=swoole", "--host=0.0.0.0", "--port=8000"]
