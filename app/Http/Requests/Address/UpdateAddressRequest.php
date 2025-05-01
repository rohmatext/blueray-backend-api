<?php

namespace App\Http\Requests\Address;

use App\Services\ProvinceService;
use Illuminate\Foundation\Http\FormRequest;

class UpdateAddressRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return $this->route('address')->user_id === $this->user()->id;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        $provinceService = new ProvinceService();

        return [
            'name' => ['required', 'string', 'max:255'],
            'phone' => ['required', 'string', 'regex:/^(\\+62|62|0)[1-9]{1}[0-9]{8,11}$/'],
            'address' => ['required', 'string', 'max:255'],
            'subdistrict' => ['required', 'string', 'max:255'],
            'city' => ['required', 'string', 'max:255'],
            'province' => ['required', 'string', 'max:255', function ($attribute, $value, $fail) use ($provinceService) {
                if ($provinceService->getProvince($value) === null) {
                    $fail(__('validation.in', ['attribute' => $attribute]));
                }
            }],
            'zip' => ['required', 'numeric', 'digits:5'],
            'note' => ['nullable', 'string', 'max:255'],
        ];
    }
}
