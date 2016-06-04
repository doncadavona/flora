# Flora

**Flora** is an app for managing and conducting pageant events. Manage events, contestants, ratings and broadcast them online.

## Setup

* Setup database following [Laravel 4.2's](http://laravel.com/docs/4.2/migration) database migration convention:
* Edit necessary database details at: '/app/config/database.php'
* Run migration: 'php artisan migrate'
* Run seeds for initial data: 'php artisan db:seed'
* Serve! Quickly serve using 'php artisan serve' then visit localhost:8000 in your browser.
** See 'app/database/seeds/UsersTableSeeder.php' for user accounts to use for loging in.

## System

Flora is written in [Laravel 4.2](http://laravel.com/docs/4.2). Of course, there's plan to shift the app to the latest Laravel framework version.
