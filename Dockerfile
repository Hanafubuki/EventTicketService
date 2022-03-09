FROM php:8.1.3

RUN apt-get update -y && apt-get install -y openssl zip unzip git procps iputils-ping
RUN curl -sS https://getcomposer.org/installer | php -- --install-dir=/usr/local/bin --filename=composer
COPY --from=composer:latest /usr/bin/composer /usr/bin/composer
RUN docker-php-ext-install pdo pdo_mysql

WORKDIR /app

COPY . .

RUN composer install
# RUN composer update 
# RUN composer update --lock
# RUN composer install

##Compose
COPY .env.example .env
#RUN php artisan passport:install
RUN php artisan key:generate

#RUN nohup php artisan queue:work >>/dev/null 2>&1 &

RUN php artisan config:cache

## Initialize server
CMD php artisan serve --host=0.0.0.0 

EXPOSE 80