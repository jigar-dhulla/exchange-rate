# Exchange Rate App

* Simple exchange rate app for EUR/INR.
* Using exchangerate.host service to fetch the rates
* Stores and Displays the history of conversions

## Tech Stack

* Laravel 10
* Livewire v2
* Bootstrap 5

## Local Setup

### Clone this project.
> git clone git@github.com:jigarakatidus/exchange-rate.git

> cd exchange-rate

### Copy Environment
> cp .env.example .env

### In `.env` file
* Change `DB_HOST` to `mysql`
* Change `CACHE_DRIVER` to `redis` to use redis service, default is `file` driver


### Install Dependency
> docker run --rm -u "$(id -u):$(id -g)" -v $(pwd):/var/www/html -w /var/www/html laravelsail/php82-composer:latest composer install --ignore-platform-reqs

### Start Services
> ./vendor/bin/sail up -d

### Generate Key
> ./vendor/bin/sail artisan key:generate

### Run Migrations
> ./vendor/bin/sail artisan migrate

### To access

Visit: http://localhost

## Services

Using Laravel Sail, a wrapper around Docker Compose.

It has:

### Web Server
Serving the application

### MySQL
Database

### Redis
Caching

## Roadmap and tech-debt

* Fallback Service if exchangerate.host is impacted #1
* Figure out ideal ttl for cache #2
* Refresh History table on form submit #3
* Tests #4

## Suggestions?

Reach out to via Twitter: @jigar_dhulla
