# Exchange Rate App

* Simple exchange rate app for EUR/INR.
* Using exchangerate.host service to fetch the rates
* Stores and Displays the history of conversions

## Tech Stack

* Laravel 10
* Livewire v2
* Bootstrap 5

## Setup

### Clone this project.
> git clone git@github.com:jigarakatidus/exchange-rate.git

### Copy Environment
> cp .env.example .env

### Install Dependency
> docker run --rm -u "$(id -u):$(id -g)" -v $(pwd):/var/www/html -w /var/www/html laravelsail/php82-composer:latest composer install --ignore-platform-reqs

### Start Services
> ./vendor/bin/sail up

### Generate Key
> ./vendor/bin/sail artisan key:generate

### Run Migrations
> ./vendor/bin/sail artisan migrate

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

* Fallback Service if exchangerate.host is impacted
* Figure out ideal ttl for cache

## Suggestions?

Reach out to via Twitter: @jigar_dhulla