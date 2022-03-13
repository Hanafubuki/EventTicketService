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
5. Access localhost:8000

## APIs
Check below the list of endpoints:
* https://documenter.getpostman.com/view/11082955/TVYDfKf4


## Tests

### Run HTTP tests
php artisan test


## Project Structure
<p><img src="Class_Diagram.png" width="600"></p>

Used Laravel's official package [Passport](https://laravel.com/docs/9.x/passport) and header-based Token Bearer authentication scheme for user authentification.

Created verification in the routes to check if user has authorization to access the APIs.



## Files created:

### Models
app/Models/*

### Controllers
app/Http/Controllers/*

### Middlewares
app/Http/Middleware/ForceJsonResponse.php


### Routes
API: routes/api.php

### Tests, Factories, Seeder
database/factories
tests/Unit


## Sources
- **[Laravel Documentation](https://laravel.com/docs)**
