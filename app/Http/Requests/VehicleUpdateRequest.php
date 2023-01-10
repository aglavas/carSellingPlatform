<?php

namespace App\Http\Requests;

use App\Service\ExchangeValidationService;
use App\Service\ImportValidationService;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Auth;
use App\Service\DataNormalizer;

class VehicleUpdateRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        $user = Auth::user();

        $vehicle = $this->route('vehicle');

        if (!$vehicle) {
            abort(404);
        }

        if (!$user->can('modify', $vehicle)) {
            return false;
        }

        return true;
    }

    /**
     * All override
     *
     * @param null $keys
     * @return array|mixed
     * @throws \Exception
     */
    public function all($keys = null)
    {
        $data = $this->input();

        $data = DataNormalizer::normalize($data, true);

        $data['vehicle'] = $this->route('vehicle');

        $this->merge($data);

        return $data;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     * @throws \Exception
     */
    public function rules()
    {
        $rules = [

        ];

        $exchangeValidationService = new ExchangeValidationService();

        $importValidationService = new ImportValidationService($exchangeValidationService);

        $additionalRules = $importValidationService->vehicleUpdateRules();

        return array_merge($rules, $additionalRules);
    }
}
