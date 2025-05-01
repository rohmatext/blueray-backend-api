<?php

namespace App\Http\Requests\Shipment;

use App\Services\Biteship\CourierService;
use App\Services\ProvinceService;
use Illuminate\Foundation\Http\FormRequest;

class StoreShipmentRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            /**
             * origin
             */
            'origin' => ['required', 'array'],
            'origin.name' => ['required', 'string', 'max:255'],
            'origin.phone' => ['required', 'string', 'regex:/^(\\+62|62|0)[1-9]{1}[0-9]{8,11}$/'],
            'origin.address' => ['required', 'string', 'max:255'],
            'origin.subdistrict' => ['required', 'string', 'max:255'],
            'origin.city' => ['required', 'string', 'max:255'],
            'origin.province' => ['required', 'string', 'max:255', function ($attribute, $value, $fail) {
                $this->validateProvince($attribute, $value, $fail);
            }],
            'origin.zip' => ['required', 'numeric', 'digits:5'],
            'origin.note' => ['nullable', 'string', 'max:255'],

            /**
             * destination
             */
            'destination' => ['required', 'array'],
            'destination.name' => ['required', 'string', 'max:255'],
            'destination.phone' => ['required', 'string', 'regex:/^(\\+62|62|0)[1-9]{1}[0-9]{8,11}$/'],
            'destination.address' => ['required', 'string', 'max:255'],
            'destination.subdistrict' => ['required', 'string', 'max:255'],
            'destination.city' => ['required', 'string', 'max:255'],
            'destination.province' => ['required', 'string', 'max:255', function ($attribute, $value, $fail) {
                $this->validateProvince($attribute, $value, $fail);
            }],
            'destination.zip' => ['required', 'numeric', 'digits:5'],
            'destination.note' => ['nullable', 'string', 'max:255'],

            /**
             * courier
             */
            'courier' => ['required', 'string', 'max:255', function ($attribute, $value, $fail) {
                $this->validateCourier($attribute, $value, $fail);
            }],

            /**
             * items
             */
            'items' => ['required', 'array'],
            'items.*' => ['required', 'array'],
            'items.*.name' => ['required', 'string', 'max:255'],
            'items.*.description' => ['required', 'string', 'max:255'],
            'items.*.value' => ['required', 'numeric', 'min:0', 'max:99999999'],
            'items.*.quantity' => ['required', 'numeric', 'min:1'],
            'items.*.weight' => ['required', 'numeric', 'min:1', 'max:9999'],
            'note' => ['nullable', 'string', 'max:255'],
        ];
    }

    private function provinceService(): ProvinceService
    {
        return new ProvinceService();
    }

    private function validateProvince($attribute, $value, $fail)
    {
        if ($this->provinceService()->getProvince($value) === null) {
            $fail(__('validation.in', ['attribute' => $attribute]));
        }
    }

    private function courierService(): CourierService
    {
        return new CourierService();
    }

    private function validateCourier($attribute, $value, $fail)
    {
        if ($this->courierService()->getByName($value) === null) {
            $fail(__('validation.in', ['attribute' => $attribute]));
        }
    }
}
