<?php

namespace App\Services;

use App\Services\Contract\ExchangeRate as ExchangeRateContract;

class Dummy implements ExchangeRateContract
{
    private const ALLOWED_CURRENCIES = [
        'EUR',
        'INR',
    ];

    public function convert(string $from, string $to): float
    {
        return 90.00;
    }

    public function getAllowedCurrencies(): array
    {
        return self::ALLOWED_CURRENCIES;
    }
}