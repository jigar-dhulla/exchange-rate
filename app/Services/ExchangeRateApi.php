<?php

namespace App\Services;

use App\Exceptions\ExchangeRateException;
use App\Services\Contract\ExchangeRate as ExchangeRateContract;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;

class ExchangeRateApi implements ExchangeRateContract
{
    private const API_URL = 'https://v6.exchangerate-api.com/v6';

    /**
     * @inheritdoc
     * @throws ExchangeRateException
     */
    public function convert(string $from, string $to): float
    {
        $cacheKey = sprintf('%s-%s-%s', __CLASS__, $from, $to);
        $ttl = (int) config('services.exchange_rate_api.ttl', 86400);
        return Cache::remember($cacheKey, $ttl, function () use ($from, $to) {
            $accessKey = config('services.exchange_rate_api.access_key');
            if (!$accessKey) {
                Log::error("Access Key not found for Exchange Rate API", [
                    'class' => __CLASS__,
                ]);
                throw new ExchangeRateException("Access Key not found for Exchange Rate API");
            }
            $uri = sprintf('/%s/latest/%s', $accessKey, $from);
            $response = Http::get(self::API_URL . $uri);
            $array = $response->json();
            if(!is_array($array) || $array['result'] !== "success"){
                Log::error("Error in API Response of Exchange Rate Conversion", [
                    'class' => __CLASS__,
                    'uri' => $uri,
                    'from' => $from,
                    'to' => $to,
                    'response' => $response->body(),
                    'status' => $response->status(),
                ]);
                throw new ExchangeRateException("Could not convert from $from to $to");
            }

            return (float) $array['conversion_rates'][$to];
        });
    }
}