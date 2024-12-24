<?php

namespace App\Services;

use App\Services\Contract\ExchangeRate as ExchangeRateContract;

class Dummy implements ExchangeRateContract
{
    public function convert(string $from, string $to): float
    {
        return 90.00;
    }
}