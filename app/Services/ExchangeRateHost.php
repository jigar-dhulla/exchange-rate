<?php

namespace App\Services;

use App\Exceptions\ExchangeRateException;
use App\Services\Contract\ExchangeRate as ExchangeRateContract;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;

class ExchangeRateHost implements ExchangeRateContract
{
    private const API_URL = 'https://api.exchangerate.host';

    /**
     * @inheritdoc
     * @throws ExchangeRateException
     */
    public function convert(string $from, string $to): float
    {
        $cacheKey = sprintf('%s-%s-%s', __CLASS__, $from, $to);
        $ttl = (int) config('services.conversion.ttl', 3600);
        return Cache::remember($cacheKey, $ttl, function () use ($from, $to) {
            $uri = sprintf('/convert?from=%s&to=%s', $from, $to);
            $response = Http::get(self::API_URL . $uri);
            $array = $response->json();
            if(!$array['success'] ?? false){
                Log::error("Error in API Response of Exchange Rate Conversion", [
                    'class' => __CLASS__,
                    'from' => $from,
                    'to' => $to,
                    'response' => $response->body(),
                    'status' => $response->status(),
                ]);
                throw new ExchangeRateException("Could not convert from $from to $to");
            }

            return (float) $array['result'];
        });
    }

    /**
     * @inheritdoc
     * @throws ExchangeRateException
     */
    public function getAllowedCurrencies(): array
    {
        $cacheKey = sprintf('%s-%s', __CLASS__, 'symbols');
        $ttl = (int) config('services.symbols.ttl', 3600);
        return Cache::remember($cacheKey, $ttl, function (){
            $response = Http::get(self::API_URL . '/symbols');
            $array = $response->json();
            if(!$array['success'] ?? false){
                Log::error("Error in API Response of fetching symbols", [
                    'class' => __CLASS__,
                    'response' => $response->body(),
                    'status' => $response->status(),
                ]);
                throw new ExchangeRateException("Could not fetch symbols");
            }

            return array_keys($array['symbols']);
        });
    }
}