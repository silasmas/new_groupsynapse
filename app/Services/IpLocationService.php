<?php

namespace App\Services;

use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Http;

class IpLocationService
{
    private const CACHE_TTL = 86400; // 24 heures

    public function getCountry(string $ip): ?string
    {
        if (in_array($ip, ['127.0.0.1', '::1', 'localhost'])) {
            return 'Local';
        }

        $cacheKey = 'ip_country_' . md5($ip);

        return Cache::remember($cacheKey, self::CACHE_TTL, function () use ($ip) {
            try {
                $response = Http::timeout(3)->get("https://ip-api.com/json/{$ip}?fields=country");
                $data = $response->json();
                return $data['country'] ?? null;
            } catch (\Throwable) {
                return null;
            }
        });
    }
}
