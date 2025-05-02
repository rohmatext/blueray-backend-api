<?php

namespace App\Http\Controllers\Api\Shipment;

use App\Http\Controllers\Controller;
use App\Services\Biteship\TrackingService;
use Illuminate\Http\Request;

class TrackingController extends Controller
{
    public function __construct(
        private TrackingService $trackingService = new TrackingService()
    ) {
        //
    }

    /**
     * Display the specified resource.
     */
    public function show(string $waybillId)
    {
        try {
            return response()->json([
                'message' => __('messages.retrieved', ['item' => 'tracking']),
                'data' => $this->trackingService->getTracking($waybillId),
            ]);
        } catch (\Exception $e) {
            return response()->json(['message' => $e->getMessage()], 500);
        }
    }
}
