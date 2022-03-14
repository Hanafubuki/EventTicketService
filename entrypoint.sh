# entrypoint.sh
#!/bin/bash
cp .env.example .env &
composer require laravel/passport &
php artisan migrate &
php artisan passport:install &
php artisan optimize &
php artisan key:generate