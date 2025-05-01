<?php

namespace App\Services;

class ProvinceService
{
    private $provinces = [
        'Aceh',
        'Sumatera Utara',
        'Sumatera Selatan',
        'Sumatera Barat',
        'Bengkulu',
        'Riau',
        'Kepulauan Riau',
        'Jambi',
        'Lampung',
        'Bangka Belitung',
        'Kalimantan Barat',
        'Kalimantan Timur',
        'Kalimantan Selatan',
        'Kalimantan Tengah',
        'Kalimantan Utara',
        'Banten',
        'DKI Jakarta',
        'Jawa Barat',
        'Jawa Tengah',
        'Daerah Istimewa Yogyakarta',
        'Jawa Timur',
        'Bali',
        'Nusa Tenggara Timur',
        'Nusa Tenggara Barat',
        'Gorontalo',
        'Sulawesi Barat',
        'Sulawesi Tengah',
        'Sulawesi Utara',
        'Sulawesi Tenggara',
        'Sulawesi Selatan',
        'Maluku Utara',
        'Maluku',
        'Papua Barat',
        'Papua',
        'Papua Tengah',
        'Papua Pegunungan',
        'Papua Selatan',
        'Papua Barat Daya',
    ];

    /**
     * Create a new class instance.
     */
    public function __construct()
    {
        //
    }

    /**
     * Get a province by name.
     *
     * @param string $province
     * 
     * @return \Illuminate\Support\Collection|null
     */
    public function getProvince(string $province)
    {
        return collect($this->provinces)->filter(fn($item) => strtolower($item) === strtolower($province))->first();
    }

    /**
     * Get all provinces in Indonesia.
     *
     * @return \Illuminate\Support\Collection
     */
    public function getProvinces()
    {
        return collect($this->provinces);
    }
}
