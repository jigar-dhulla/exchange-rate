<?php

namespace App\Services\Contract;

interface ExchangeRate
{
    /**
     * Get the Exchange Rate
     */
    public function convert(string $from, string $to): float;

    /**
     * Get valid currencies
     */
    public function getAllowedCurrencies(): array;
}