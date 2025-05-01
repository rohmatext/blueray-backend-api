<?php

namespace App\Services;

use App\Models\Address;
use Illuminate\Support\Facades\Auth;

class AddressService
{
    /**
     * Create a new class instance.
     */
    public function __construct()
    {
        //
    }

    /**
     * Fetch all addresses associated with the authenticated user.
     *
     * @return \Illuminate\Database\Eloquent\Collection
     */
    public function fetchAddressByUser()
    {
        return Address::byUser(Auth::id())->get();
    }

    /**
     * Fetch the address with the specified ID.
     *
     * @param int $id The ID of the address to fetch.
     * 
     * @return \App\Models\Address|null
     */
    public function fetchAddress(Address $address)
    {
        return $address;
    }

    /**
     * Store a new address for the authenticated user.
     *
     * @param array $data The address data to store
     * 
     * @return \App\Models\Address The newly created address instance.
     */
    public function storeAddress(array $data)
    {
        return Address::create([
            'user_id' => Auth::id(),
            'name' => $data['name'],
            'phone' => $data['phone'],
            'address' => $data['address'],
            'subdistrict' => $data['subdistrict'],
            'city' => $data['city'],
            'province' => $data['province'],
            'zip' => $data['zip'],
            'note' => $data['note'] ?? null,
        ]);
    }

    /**
     * Update the specified address with new data.
     *
     * @param \App\Models\Address $address The address to update.
     * @param array $data An array containing the address's new data.
     * 
     * @return \App\Models\Address The updated address instance.
     */
    public function updateAddress(Address $address, array $data)
    {
        return tap($address)->update([
            'name' => $data['name'],
            'phone' => $data['phone'],
            'address' => $data['address'],
            'subdistrict' => $data['subdistrict'],
            'city' => $data['city'],
            'province' => $data['province'],
            'zip' => $data['zip'],
            'note' => $data['note'] ?? null,
        ]);
    }

    /**
     * Delete the specified address.
     *
     * @param \App\Models\Address $address The address to delete.
     * 
     * @return bool|null
     */
    public function deleteAddress(Address $address)
    {
        return $address->delete();
    }
}
