<?php

namespace App\Services\Biteship;

class CourierService
{

    private array $couriers = [
        ["company" => "sicepat", "name" => "Sicepat Reguler", "type" => "reg"],
        ["company" => "sicepat", "name" => "Sicepat Best", "type" => "best"],
        ["company" => "sicepat", "name" => "Sicepat SDS", "type" => "sds"],
        ["company" => "sicepat", "name" => "Sicepat GOKIL", "type" => "gokil"],
        ["company" => "jne", "name" => "JNE Reguler", "type" => "reg"],
        ["company" => "jne", "name" => "JNE YES", "type" => "yes"],
        ["company" => "jne", "name" => "JNE OKE", "type" => "oke"],
        ["company" => "jne", "name" => "JNE JTR", "type" => "jtr"],
        ["company" => "jnt", "name" => "J&T EZ", "type" => "ez"],
        ["company" => "anteraja", "name" => "Anteraja Reguler", "type" => "reg"],
    ];

    /**
     * Create a new class instance.
     */
    public function __construct()
    {
        //
    }

    /**
     * Get all available couriers.
     *
     * @return \Illuminate\Support\Collection
     */
    public function getAllCouriers()
    {
        return collect($this->couriers);
    }

    /**
     * Get courier by name.
     *
     * @param string $name
     * @return array|null
     */
    public function getByName(string $name)
    {
        return $this->getAllCouriers()
            ->filter(
                fn($item) => strtolower($item['name']) === strtolower($name)
            )
            ->first();
    }
}
