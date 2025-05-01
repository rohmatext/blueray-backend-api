<?php

namespace App\Http\Controllers\Api\Shipment;

use App\Http\Controllers\Controller;
use App\Services\Biteship\CourierService;
use Illuminate\Http\Request;

class CourierController extends Controller
{
    public function __construct(
        private CourierService $courierService = new CourierService()
    ) {
        //
    }
    /**
     * Display a listing of couriers.
     */
    public function index()
    {
        return response()->json([
            'data' => $this->courierService->getAllCouriers(),
            'message' => __('messages.retrieved', ['item' => 'couriers']),
        ]);
    }
}
