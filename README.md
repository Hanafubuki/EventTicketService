# EventTicketService

## Table of Contents
- **[Introduction](#introduction)**
- **[Technologies](#technologies)**
- **[Setup](#setup)**
- **[APIs](#apis)**
- **[Tests](#tests)**
- **[Project Structure](#project-structure)**


## Introduction
Cloud-based backend service that emulates a simple event ticket service. 


## Technologies
- PHP 8.1
- Laravel 9
- MySQL 8.0


## Setup
To run this project:
1. Clone this project.
2. cd EventTicketService
3. docker-compose build
4. docker-compose up
5. docker exec -it main /bin/bash ./entrypoint.sh
6. Access localhost:8000

## APIs
Check below the list of endpoints:
* https://documenter.getpostman.com/view/11082955/UVsJwSQz


## Tests

### Run tests
docker exec -it main php artisan test
OR
docker exec -it main ./vendor/bin/phpunit


## Project Structure

Used Laravel's official package [Passport](https://laravel.com/docs/9.x/passport) and header-based Token Bearer authentication scheme for user authentification.

Created verification in the routes to check if user has authorization to access the APIs.



## Files created:

### Models
app/Models/*

### Controllers
app/Http/Controllers/*

### Middlewares
app/Http/Middleware/ForceJsonResponse.php

app/Http/Middleware/CheckCorrectUser.php

### Routes
API: routes/api.php

### Tests, Factories, Seeder
database/factories/*

tests/Unit/*


## Sources
- **[Laravel Documentation](https://laravel.com/docs)**
