# entrypoint.sh
#!/usr/bin/env sh
echo "Installing composer packages" &
composer install &
echo "Installing node packages" &
npm install &
echo "Setting up environment" &
cp .env.example .env &
composer require laravel/passport &
php artisan migrate &
php artisan passport:install &
php artisan key:generate &
php artisan optimize &
echo "Starting server" &
php artisan serve --host=0.0.0.0