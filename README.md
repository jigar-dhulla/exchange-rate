# Exchange Rate App

* Simple exchange rate app for EUR/INR.
* Using exchangerate.host service to fetch the rates
* Stores and Displays the history of conversions

# Explanation of this repo
This repo was featured in [Laravel Daily](https://www.youtube.com/@LaravelDaily) youtube channel
* Video 1: https://www.youtube.com/watch?v=YSZqSUe4m7I
* Video 2: https://www.youtube.com/watch?v=5cSTC3AG3tQ

## Tech Stack

* Laravel 10
* Livewire v3
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
* Change `REDIS_HOST` to `redis`
* Create Exchange Rate Host API Key and add the same to `EXCHANGE_RATE_HOST_ACCESS_KEY`

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

## Suggestions?

Reach out to via Twitter: @jigar_dhulla
