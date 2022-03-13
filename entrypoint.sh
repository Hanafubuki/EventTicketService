# entrypoint.sh
#!/bin/bash

composer install 
cp .env.example .env
composer require laravel/passport
php artisan migrate
php artisan passport:install
php artisan key:generate
php artisan optimize
php artisan serve --host=0.0.0.0