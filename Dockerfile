FROM php:8.1.3

RUN apt-get update -y && apt-get install -y openssl zip unzip git procps iputils-ping npm
RUN curl -sS https://getcomposer.org/installer | php -- --install-dir=/usr/local/bin --filename=composer
COPY --from=composer:latest /usr/bin/composer /usr/bin/composer
RUN docker-php-ext-install pdo pdo_mysql

WORKDIR /app

COPY . .

COPY ./entrypoint.sh ./entrypoint.sh

CMD bash -c "composer install && composer require laravel/passport && php artisan serve --host 0.0.0.0"

EXPOSE 80