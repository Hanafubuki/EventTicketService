# EventTicketService
<p><img src="System_Architecture.png" width="600"></p>

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
5. Access localhost:8000

## APIs
Check below the list of endpoints:
* https://documenter.getpostman.com/view/11082955/TVYDfKf4

<p><img src="Postman.png" width="600"></p>

## Tests
### Add dummy data to DB
php artisan db:seed

### Run HTTP tests
php artisan test


## Project Structure
<p><img src="Class_Diagram.png" width="600"></p>

Used Laravel's official package [Passport](https://laravel.com/docs/8.x/passport) and header-based Token Bearer authentication scheme for user authentification.

Created verification in the routes to check if user has authorization to access the APIs.

PSR-4: Autoloads factories, seeders and tests and, added autoload for helper functions.

Used DRY principles.



## Files created:

### Models
User: app/Models/User.php

Tweet: app/Models/Tweet.php

### Controllers
Authorization Controller: app/Http/Controllers/AuthsController.php

User Controller: app/Http/Controllers/UsersController.php

Tweet Controller: app/Http/Controllers/TweetsController.php

### Middlewares
Transform json automatically in return methods: app/Http/Middleware/ForceJsonResponse.php

Accept CORS: app/Http/Middleware/ForceJsonResponse.php

### Helpers
Error messages: app/Helpers/errorHelper.php

User: app/Helpers/userHelper.php

### Routes
API: routes/api.php

### Tests, Factories, Seeder
database/factories

database/seeders

tests/Feature


## Sources
- **[Laravel Documentation](https://laravel.com/docs)**
