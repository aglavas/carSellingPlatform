<?php

namespace App\Http\Requests\Auth;

use Illuminate\Foundation\Http\FormRequest;

class RegisterRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'email', 'max:255', 'unique:users'],
            'password' => ['required', 'string', 'min:8', 'confirmed'],
            'company' => ['required_without:company_name', 'exists:companies,id', 'integer'],
            'company_name' => ['required_without:company', 'string'],
            'company_address' => ['required_without:company', 'string'],
            'country' => ['required', 'string'],
            'stock_type' => ['required', 'in:UC,NC,both'],
            'function_description' => ['nullable', 'string'],
            'telephone' => ['nullable', 'string'],
            'mobile' => ['nullable', 'string'],
            'role' => ['required', 'array'],
            'role.*' => ['required', 'integer', 'exists:roles,id', 'nonAdmin'],
            'brand' => ['required_unless:stock_type,UC', 'array'],
            'brand.*' => ['required_with:brand', 'integer', 'exists:brands,id'],
            'vehicle_type' => ['required', 'array'],
            'vehicle_type.*' => ['string', 'in:Truck,LCV,Passenger'],
        ];
    }
}
