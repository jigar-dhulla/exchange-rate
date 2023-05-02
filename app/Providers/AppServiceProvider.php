<?php

namespace App\Providers;

use App\Services\Contract\ExchangeRate as ExchangeRateContract;
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
        $this->app->bind(ExchangeRateContract::class, ExchangeRateHost::class);
    }
}
