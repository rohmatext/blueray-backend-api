<?php

namespace App\Services\Biteship;

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Http;

class OrderService
{
    const PATH = 'v1/orders';

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

    public function getOrder(string $orderId)
    {
        $key = 'order_' . $orderId;
        if (Cache::has($key)) {
            return Cache::get($key);
        }

        $url = config('biteship.url') . '/' . self::PATH . '/' . $orderId;

        $response = $this->client->get($url);
        if ($response->failed()) {
            throw new \Exception($response->body());
        }

        return Cache::remember(
            $key,
            now()->addMinutes(5),
            fn() => $response->collect()
        );
    }

    public function createOrder(array $values)
    {
        $url = config('biteship.url') . '/' . self::PATH;

        $data = [
            ...$this->getShipperDetail(),
            ...$this->originDetail($values['origin']),
            ...$this->destinationDetail($values['destination']),
            ...$this->courierDetail($values['courier']),
            "delivery_type" => "now",
            "order_note" => isset($values['note']) ? $values['note'] : null,
            "items" => $values['items'],
        ];

        $response = $this->client->post($url, $data);

        if ($response->failed()) {
            throw new \Exception($response->body());
        }

        return $response->collect();
    }

    private function getShipperDetail()
    {
        $user = Auth::user();
        return [
            'shipper_contact_name' => $user->name,
            'shipper_contact_email' => $user->email,
            'shipper_contact_phone' => "081234567890",
            'shipper_organization' => "Sendev",
        ];
    }

    private function originDetail(array $values)
    {
        return [
            "origin_contact_name" => $values['name'],
            "origin_contact_phone" => $values['phone'],
            "origin_address" => $this->getFullAddress($values),
            "origin_note" => $values['note'] ?? null,
            "origin_postal_code" => $values['zip'],
        ];
    }

    private function destinationDetail(array $values)
    {
        return [
            "destination_contact_name" => $values['name'],
            "destination_contact_phone" => $values['phone'],
            "destination_address" => $this->getFullAddress($values),
            "destination_note" => $values['note'] ?? null,
            "destination_postal_code" => $values['zip'],
        ];
    }

    private function courierDetail(string $value)
    {
        $courierService = new CourierService();
        $courier = $courierService->getByName($value);

        return [
            "courier_company" => $courier['company'],
            "courier_type" => $courier['type'],
        ];
    }

    private function getFullAddress(array $values)
    {
        return $values['address'] . ', Kecamatan ' . $values['subdistrict'] . ', Kota/Kabupaten ' . $values['city'] . ', Provinsi ' . $values['province'] . ', Kode pos ' . $values['zip'];
    }
}
