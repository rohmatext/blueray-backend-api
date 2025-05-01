<?php

namespace App\Http\Controllers\Api\Shipment;

use App\Http\Controllers\Controller;
use App\Http\Requests\Shipment\StoreShipmentRequest;
use App\Http\Resources\ShipmentResource;
use App\Models\Shipment;
use App\Services\Biteship\OrderService;
use App\Services\ShipmentService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Http;

class ShipmentController extends Controller
{
    public function __construct(
        private OrderService $orderService = new OrderService(),
        private ShipmentService $shipmentService = new ShipmentService()
    ) {
        //
    }
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return ShipmentResource::collection($this->shipmentService->fetchAllShipments())
            ->additional([
                'message' => __('messages.retrieved', ['item' => 'shipments']),
            ])
            ->response()
            ->setStatusCode(200);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreShipmentRequest $request)
    {
        try {
            DB::beginTransaction();
            $order = $this->orderService->createOrder($request->validated());
            $shipment = $this->shipmentService->createShipment($order->toArray());
            DB::commit();

            return (new ShipmentResource($shipment))
                ->additional([
                    'message' => __('messages.created', ['item' => 'shipment']),
                ])
                ->response()
                ->setStatusCode(201);
        } catch (\Throwable $th) {
            DB::rollBack();

            return response()->json([
                'message' => __('messages.process_failed'),
                'error' => $th->getMessage(),
            ], 500);
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
