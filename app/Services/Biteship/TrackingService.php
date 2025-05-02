<?php

namespace App\Services\Biteship;

use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Http;

class TrackingService
{
    const PATH = '/v1/trackings';

    private $client;

    /**
     * Create a new class instance.
     */
    public function __construct()
    {
        $this->client = Http::withHeaders([
            'Content-Type' => 'application/json',
            'Accept' => 'application/json',
            'Authorization' => config('biteship.api_key'),
        ]);
    }

    public function getTracking(string $trackingNumber)
    {
        $key = 'tracking_' . $trackingNumber;
        if (Cache::has($key)) {
            return Cache::get($key);
        }

        $url = config('biteship.url') . self::PATH . '/' . $trackingNumber;
        $response = $this->client->get($url);
        if ($response->failed()) {
            throw new \Exception($response->body());
        }

        return Cache::remember(
            $key,
            now()->addMinutes(5),
            fn() =>
            $response->collect()
        );
    }
}
