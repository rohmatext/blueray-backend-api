<?php

namespace App\Http\Controllers\Api\Address;

use App\Http\Controllers\Controller;
use App\Http\Resources\ProvinceResource;
use App\Services\ProvinceService;
use Illuminate\Http\Request;

class ProvinceController extends Controller
{
    public function __construct(
        private ProvinceService $provinceService = new ProvinceService()
    ) {
        //
    }
    /**
     * Display a listing of provinces or specific province.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $province = request()->query('province');

        if ($province) {
            return response()->json([
                'data' => $this->provinceService->getProvince($province),
                'message' => __('messages.retrieved', ['item' => 'provinsi']),
            ]);
        }

        return response()->json([
            'data' => $this->provinceService->getProvinces(),
            'message' => __('messages.retrieved', ['item' => 'provinsi']),
        ]);
    }
}
