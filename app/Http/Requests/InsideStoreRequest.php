<?php

namespace App\Http\Requests;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Auth;

class InsideStoreRequest extends FormRequest
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
     * All override
     *
     * @param null $keys
     * @return array|mixed
     */
    public function all($keys = null)
    {
        $request = $this->input();

        if (isset($request['de'])) {
            $request = $request['de'];
        }

        return $request;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'ChassisCode' => ['required','unique:stock_vehicles,manufacturer_id'],
            'CountryOrigin' => ['required', 'string'], //missing
            'MakeText' => ['required', 'string'],
            'ModelText' => ['required', 'string'],
            'ModelTypeText' => ['required', 'string'],
            'Ccm' => ['required', 'alpha_num'],
            'Hp' => ['required', 'alpha_num'], //add KW data for engine
            'FuelTypeText' => ['required', 'string'],
            'TransmissionTypeText' => ['required', 'in:0,1,A,M,AUTOMATIC,MANUAL'],
            'Km' => ['numeric', 'required'],
            'FirstRegMonth' => ['numeric', 'required'],
            'FirstRegYear' => ['numeric', 'required'],
            'BodyColorCode' => ['nullable', 'alpha_num'], //Missing
            'BodyColorText' => ['required', 'string'], //Missing
            'Equipment' => ['nullable', 'array'], //option code and description
            'Co2Emission' => ['numeric', 'required'],
            'B2bPriceExVat' => ['lt:1000000000000', 'numeric', 'required'], //missing
            'VatDeductible' => ['required'], //missing
            'WarrantyDescription' => ['nullable'],
            'Availability' => ['nullable'],
            'Seller' => 'required',
            'Comments' => ['nullable', 'string'],
//            'LanguageCodeTrans' => ['required', 'integer', 'in:0,1'], //missing, could be picked up from key possibly
            'CurrencyIso' => ['required', 'string'], //missing
            'URLmarketplace' => ['nullable', 'string'], //missing
            'Images' => ['nullable', 'array'],
            'ConditionTypeText' => 'required|string|in:used,new,demo,new_registered,Used,New,Demo', //they have different values
            'VehicleType' => 'required|string|in:Passenger,LCV,Truck|vpvuValid', //they send integer
            'AccountId' => ['nullable', 'integer'], //connectivity partner id - company id from their database
            'BodyTypeText' => ['nullable', 'string'],
            'CarNumber' => ['nullable', 'string'],
            'CertificationCode' => ['nullable', 'string'],
            'ConsumptionCity' => ['nullable', 'numeric'],
            'ConsumptionLand' => ['nullable', 'numeric'],
            'ConsumptionRatingText' => ['nullable', 'string'],
            'ConsumptionTotal' => ['nullable', 'numeric'],
            'Cylinders' => ['nullable', 'integer'],
            'Documents' => ['nullable', 'array'],
            'Doors' => ['nullable', 'integer'],
            'DriveTypeText' => ['nullable', 'string'],
            'HasWarranty' => 'in:0,1',
            'Id' => ['nullable', 'integer'], // external id - inside_id: 343
            'ModelGroupText' => ['nullable', 'string'],
            'PollutionNormTypeText' => ['nullable', 'string'],
            'Price' => ['nullable', 'numeric'],
            'PriceHistory' => ['nullable'],
            'PriceNew' => ['nullable', 'numeric'],
            'Properties' => ['nullable', 'array'],
            'AdditionalProperties' => ['nullable', 'array'], //missing
            'Seats' => ['nullable', 'integer'],
            'SegmentationId' => ['nullable', 'alpha_num'],
            'Teaser' => ['nullable', 'string'],
            'Videos' => ['nullable', 'array'],
            'Weight' => ['nullable', 'integer'],
        ];
    }
}
