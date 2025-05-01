<?php

namespace App\Services;

use App\Models\Shipment;
use Illuminate\Support\Facades\Auth;

class ShipmentService
{
    /**
     * Create a new class instance.
     */
    public function __construct()
    {
        //
    }

    public function fetchAllShipments()
    {
        $role = Auth::user()->roles->pluck('name')->first();
        if ($role === 'user') {
            return Shipment::with('items')->byUser(Auth::id())->get();
        }

        return Shipment::with('items')->get();
    }

    public function createShipment(array $data)
    {
        $shipment = Shipment::create([
            'user_id' => Auth::id(),
            'external_id' => $data['id'],
            'status' => $data['status'],
            'courier_company' => $data['courier']['company'],
            'courier_type' => $data['courier']['type'],
            'courier_link' => $data['courier']['link'],
            'tracking_id' => $data['courier']['tracking_id'],
            'delivery_type' => $data['delivery']['type'],
            'delivery_datetime' => $data['delivery']['datetime'],
            'price' => $data['price'],
            'shipper_name' => $data['shipper']['name'],
            'origin_name' => $data['origin']['contact_name'],
            'origin_phone' => $data['origin']['contact_phone'],
            'origin_address' => $data['origin']['address'],
            'destination_name' => $data['destination']['contact_name'],
            'destination_phone' => $data['destination']['contact_phone'],
            'destination_address' => $data['destination']['address'],
            'reference_id' => $data['reference_id'] ?? null,
            'raw_response' => $data,
            'note' => $data['note'] ?? null,
        ]);

        $this->createShipmentItems($shipment, $data['items']);

        return $shipment;
    }

    public function createShipmentItems(Shipment $shipment, array $items)
    {
        return $shipment->items()->createMany($items);
    }
}
