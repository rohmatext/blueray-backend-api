<?php

namespace App\Http\Controllers\Api\Address;

use App\Http\Controllers\Controller;
use App\Http\Requests\Address\StoreAddressRequest;
use App\Http\Requests\Address\UpdateAddressRequest;
use App\Http\Resources\AddressResource;
use App\Models\Address;
use App\Services\AddressService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class AddressController extends Controller
{
    public function __construct(
        private AddressService $addressService = new AddressService()
    ) {
        //
    }
    /**
     * Display a listing of addresses.
     */
    public function index()
    {
        $addresses = $this->addressService->fetchAddressByUser();

        return AddressResource::collection($addresses)
            ->additional([
                'message' => __('messages.retrieved', ['item' => 'addresses']),
            ])
            ->response()
            ->setStatusCode(200);
    }

    /**
     * Display the specified address.
     */
    public function show(Address $address)
    {
        abort_if($address->user_id !== Auth::id(), 403, __('messages.forbidden'));

        return (new AddressResource($this->addressService->fetchAddress($address)))
            ->additional([
                'message' => __('messages.retrieved', ['item' => 'address']),
            ])
            ->response()
            ->setStatusCode(200);
    }

    /**
     * Store a newly created address in storage.
     */
    public function store(StoreAddressRequest $request)
    {
        try {
            DB::beginTransaction();
            $created = $this->addressService->storeAddress($request->validated());
            DB::commit();

            return (new AddressResource($created))
                ->additional([
                    'message' => __('messages.created', ['item' => 'address']),
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
     * Update the specified address in storage.
     */
    public function update(UpdateAddressRequest $request, Address $address)
    {
        try {
            DB::beginTransaction();
            $updated = $this->addressService->updateAddress($address, $request->validated());
            DB::commit();

            return (new AddressResource($updated))
                ->additional([
                    'message' => __('messages.updated', ['item' => 'address']),
                ])
                ->response()
                ->setStatusCode(200);
        } catch (\Throwable $th) {
            DB::rollBack();
            return response()->json([
                'message' => __('messages.process_failed'),
                'error' => $th->getMessage(),
            ], 500);
        }
    }

    /**
     * Remove the specified address from storage.
     */
    public function destroy(Address $address)
    {
        abort_if($address->user_id !== Auth::id(), 403, __('messages.forbidden'));

        try {
            DB::beginTransaction();
            $this->addressService->deleteAddress($address);
            DB::commit();

            return response()->json([
                'message' => __('messages.deleted', ['item' => 'address']),
            ]);
        } catch (\Throwable $th) {
            DB::rollBack();
            return response()->json([
                'message' => __('messages.process_failed'),
                'error' => $th->getMessage(),
            ], 500);
        }
    }
}
