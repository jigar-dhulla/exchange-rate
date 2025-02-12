<?php

namespace App\Providers;

use App\Services\Contract\ExchangeRate as ExchangeRateContract;
use App\Services\ExchangeRateApi;
use App\Services\ExchangeRateHost;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        $this->app->bind(ExchangeRateContract::class, function () {
            $driver = config('services.exchange_rate.driver');
            if (!$driver) {
                throw new \InvalidArgumentException("Exchange Rate Driver not found");
            }
            return match ($driver) {
                'exchange_rate_host' => new ExchangeRateHost(),
                'exchange_rate_api' => new ExchangeRateApi(),
                default => throw new \InvalidArgumentException("Invalid Exchange Rate Driver: $driver"),
            };
        });
    }
}
