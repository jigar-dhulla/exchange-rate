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
            $accessKey = config('services.exchange_rate_host.access_key');
            if (!$accessKey) {
                Log::error("Access Key not found for Exchange Rate Host", [
                    'class' => __CLASS__,
                ]);
                throw new ExchangeRateException("Access Key not found for Exchange Rate Host");
            }
            $uri = sprintf('/convert?from=%s&to=%s&amount=1&access_key=%s', $from, $to, $accessKey);
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
}