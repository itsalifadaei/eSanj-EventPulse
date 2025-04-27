FROM phpswoole/swoole:6.0.1-php8.3

WORKDIR /app

RUN apt update && apt install -y autoconf zlib1g-dev php-dev php-pear \
    && pecl install grpc

RUN docker-php-ext-enable grpc
RUN docker-php-ext-install pcntl


COPY --from=composer:2.7 /usr/bin/composer /usr/bin/composer

COPY query-api/. .

RUN composer install --no-dev --optimize-autoloader

RUN mkdir -p storage/framework/cache storage/framework/sessions storage/framework/views storage/logs \
    && chmod -R 775 storage bootstrap/cache

ENV APP_ENV=production
ENV APP_DEBUG=true

EXPOSE 8000

CMD ["php", "artisan", "octane:start", "--server=swoole", "--host=0.0.0.0", "--port=8000"]
