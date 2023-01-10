<?php

namespace App\Service;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;
use function Symfony\Component\Translation\t;

class ImportValidationService
{
    /**
     * @var ExchangeValidationService
     */
    public $exchangeValidationService;

    /**
     * ImportValidationService constructor.
     * @param ExchangeValidationService $exchangeValidationService
     */
    public function __construct(ExchangeValidationService $exchangeValidationService)
    {
        $this->exchangeValidationService = $exchangeValidationService;
    }

    /**
     * Validate import data
     *
     * @param array $data
     * @return array|bool
     */
    public function validateImportData(array $data)
    {
        $rules = $this->getRules();

        $validator = Validator::make($data, $rules);

        if ($validator->fails()) {
            $errorMessageBag = $validator->errors();

            $errorArray = $errorMessageBag->toArray();

            return $errorArray;
        }

        return true;
    }

    /**
     * Get rules for creation
     *
     * @return array
     */
    public function getRules()
    {
        $user = Auth::user();

        $mappingArray = config('carmarket.imports.used.cz.mappings');

        $companyId = $mappingArray['company_data']['company_id'];

        if (($user->stock_type === 'NC' && $user->import_types === 'I') || ($user->company_id == $companyId)) {
            return [
                'manufacturer_id' => ['required','unique:stock_vehicles,manufacturer_id'],
                'origin' => ['required', 'string'],
                'brand' => ['required', 'string', 'correctBrand', 'bail'],
                'model' => ['required'],
                'version_code' => ['nullable'],
                'version_description' => ['required', 'string'],
                'fuel_type' => ['nullable', 'string', 'in:Petrol,Gasoline,Diesel,Hybrid,Electric,LPG,Other Fuels,Alcohol,Cryogenic,Waterstof,Waterstoff,Hybrid(Petrol),Hybrid(Diesel)'],
                'gearbox' => ['nullable', 'in:0,1,A,M,AUTOMATIC,MANUAL'],
                'km' => ['nullable', 'gt:0'],
                'cm3' => ['nullable', 'integer', 'gt:0'],
                'kw' => ['nullable', 'integer', 'gt:0'],
                'hp' => ['nullable', 'integer', 'gt:0'],
                'firstregistration' => ['nullable', 'validFirstRegDate'],
                'interior' => ['nullable'],
                'color_code' => ['nullable'],
                'color_description' => ['required', 'string'],
                'options_code' => ['nullable'],
                'option_code_description' => ['nullable', 'string'],
                'co2' => ['integer', 'nullable', 'gt:0'],
                'b2b_price_ex_vat' => ['lt:99999999999', 'gt:0', 'numeric', 'nullable'],
                'vat_deductible' => ['nullable'],
                'damages_excl_vat_info' => ['nullable'],
                'disponibility' => [
                    function ($attribute, $value, $onFailure) {
                    try {
                        convert_to_excel_dates_to_date($value);
                    } catch (\Exception $exception) {
                        $onFailure($attribute . ': ' . $exception->getMessage());
                    }
                }, 'nullable'
                ],
                'loading_place' => 'nullable|string',
                'note' => ['nullable', 'string'],
                'language_option_code_description' => ['nullable', 'integer', 'in:0,1'],
                'currency_iso_codification' => [
                    function ($attribute, $value, $onFailure) {
                        try {
                            $this->exchangeValidationService->validateCurrencyCode($value ?? '');
                        } catch (\Exception $exception) {
                            $onFailure($attribute . ': ' . $exception->getMessage());
                        }
                    },
                    'nullable'
                ],
                'url_address' => ['nullable', 'string'],
                'media_path' => ['nullable', 'string'],
                'condition_type' => 'required|string|in:used,new,demo,new_registered|correctConditionType|bail',
                'vehicle_type' => 'required|string|in:Passenger,LCV,Truck|vpvuValid',
                'account_id' => ['nullable', 'alpha_num'],
                'body_type' => ['nullable', 'string'],
                'sku_number' => ['nullable', 'string'],
                'certification_code' => ['nullable', 'string'],
                'fuel_consumption_city' => ['nullable', 'numeric', 'gt:0'],
                'fuel_consumption_land' => ['nullable', 'numeric', 'gt:0'],
                'fuel_consumption_rating' => ['nullable', 'string'],
                'fuel_consumption_total' => ['nullable', 'numeric', 'gt:0'],
                'cylinders' => ['nullable', 'integer', 'gt:0'],
                'documents' => ['nullable', 'string'],
                'coc' => ['nullable', 'string'],
                'doors' => ['nullable', 'integer', 'gt:0'],
                'drive_type' => ['nullable', 'string'],
                'has_warranty' => ['nullable', 'in:0,1'],
                'id' => ['nullable', 'externalId'],
                'model_group' => ['nullable', 'string'],
                'pollution_norm' => ['nullable', 'string', 'in:EURO0,EURO1,EURO2,EURO3,EURO4,EURO5,EURO6,EURO5A,EURO5B,EURO6A,EURO6B,EURO6C,EURO6D,EURO6+'],
                'price' => ['nullable', 'numeric'],
                'price_history' => ['nullable'],
                'price_new' => ['nullable', 'numeric'],
                'properties' => ['nullable', 'string'],
                'additional_properties' => ['nullable', 'string'],
                'seats' => ['nullable', 'integer'],
                'segmentation_id' => ['nullable', 'alpha_num'],
                'teaser' => ['nullable', 'string'],
                'videos' => ['nullable', 'string'],
                'weight' => ['nullable', 'integer', 'gt:0'],
            ];
        }

        return [
            'manufacturer_id' => ['required','unique:stock_vehicles,manufacturer_id'],
            'origin' => ['required', 'string'],
            'brand' => ['required', 'string', 'correctBrand', 'bail'],
            'model' => ['required'],
            'version_code' => ['nullable'],
            'version_description' => ['required', 'string'],
            'fuel_type' => ['required', 'string', 'in:Petrol,Gasoline,Diesel,Hybrid,Electric,LPG,Other Fuels,Alcohol,Cryogenic,Waterstof,Waterstoff,Hybrid(Petrol),Hybrid(Diesel)'],
            'gearbox' => ['required', 'in:0,1,A,M,AUTOMATIC,MANUAL'],
            'km' => ['numeric', 'required', 'gt:0'],
            'cm3' => ['required', 'integer', 'gt:0'],
            'kw' => ['required', 'integer', 'gt:0'],
            'hp' => ['required', 'integer', 'gt:0'],
            'firstregistration' => ['required', 'validFirstRegDate'],
            'interior' => ['nullable'],
            'color_code' => ['nullable'],
            'color_description' => ['required', 'string'],
            'options_code' => ['nullable'],
            'option_code_description' => ['nullable', 'string'],
            'co2' => ['integer', 'required', 'gt:0'],
            'b2b_price_ex_vat' => ['lt:99999999999', 'gt:1', 'numeric', 'required'],
            'vat_deductible' => ['required'],
            'damages_excl_vat_info' => ['nullable'],
            'disponibility' => function ($attribute, $value, $onFailure) {
                try {
                    convert_to_excel_dates_to_date($value);
                } catch (\Exception $exception) {
                    $onFailure($attribute . ': ' . $exception->getMessage());
                }
            },
            'loading_place' => 'required|string',
            'note' => ['nullable', 'string'],
            'language_option_code_description' => ['required', 'integer', 'in:0,1'],
            'currency_iso_codification' => [
                function ($attribute, $value, $onFailure) {
                    try {
                        $this->exchangeValidationService->validateCurrencyCode($value ?? '');
                    } catch (\Exception $exception) {
                        $onFailure($attribute . ': ' . $exception->getMessage());
                    }
                },
                'required'
            ],
            'url_address' => ['nullable', 'string'],
            'media_path' => ['nullable', 'string'],
            'condition_type' => 'required|string|in:used,new,demo,new_registered|correctConditionType|bail',
            'vehicle_type' => 'required|string|in:Passenger,LCV,Truck|vpvuValid',
            'account_id' => ['nullable', 'alpha_num'],
            'body_type' => ['nullable', 'string'],
            'sku_number' => ['nullable', 'string'],
            'certification_code' => ['nullable', 'string'],
            'fuel_consumption_city' => ['nullable', 'numeric', 'gt:0'],
            'fuel_consumption_land' => ['nullable', 'numeric', 'gt:0'],
            'fuel_consumption_rating' => ['nullable', 'string'],
            'fuel_consumption_total' => ['nullable', 'numeric', 'gt:0'],
            'cylinders' => ['nullable', 'integer', 'gt:0'],
            'documents' => ['nullable', 'string'],
            'coc' => ['nullable', 'string'],
            'doors' => ['nullable', 'integer', 'gt:0'],
            'drive_type' => ['nullable', 'string'],
            'has_warranty' => 'in:0,1',
            'id' => ['nullable', 'externalId'],
            'model_group' => ['nullable', 'string'],
            'pollution_norm' => ['required', 'string', 'in:EURO0,EURO1,EURO2,EURO3,EURO4,EURO5,EURO6,EURO5A,EURO5B,EURO6A,EURO6B,EURO6C,EURO6D,EURO6+'],
            'price' => ['nullable', 'numeric'],
            'price_history' => ['nullable'],
            'price_new' => ['nullable', 'numeric'],
            'properties' => ['nullable', 'string'],
            'additional_properties' => ['nullable', 'string'],
            'seats' => ['nullable', 'integer'],
            'segmentation_id' => ['nullable', 'alpha_num'],
            'teaser' => ['nullable', 'string'],
            'videos' => ['nullable', 'string'],
            'weight' => ['required', 'integer', 'gt:0'],
        ];
    }

    /**
     * Vehicle update rules
     *
     * @return array
     */
    public function vehicleUpdateRules()
    {
        return [
            'origin' => ['required', 'string'],
            'brand' => ['required', 'string', 'correctBrand', 'bail'],
            'model' => ['required'],
            'version_code' => ['nullable'],
            'version_description' => ['required', 'string'],
            'km' => ['numeric', 'required', 'gt:0'],
            'cm3' => ['required', 'integer', 'gt:0'],
            'kw' => ['required', 'integer', 'gt:0'],
            'hp' => ['required', 'integer', 'gt:0'],
            'fuel_type' => ['required', 'string', 'in:Petrol,Gasoline,Diesel,Hybrid,Electric,LPG,Other Fuels,Alcohol,Cryogenic,Waterstof,Waterstoff,Hybrid(Petrol),Hybrid(Diesel)'],
            'gearbox' => ['required', 'in:0,1,A,M,AUTOMATIC,MANUAL'],
            'firstregistration' => ['required', 'validFirstRegDate'],
            'color_code' => ['nullable'],
            'color_description' => ['required', 'string'],
            'interior' => ['nullable'],
            'options_code' => ['nullable'],
            'option_code_description' => ['nullable', 'string'],
            'co2' => ['integer', 'required', 'gt:0'],
            'b2b_price_ex_vat' => ['lt:99999999999', 'gt:1', 'numeric', 'required'],
            'vat_deductible' => ['required'],
            'damages_excl_vat_info' => ['nullable'],
            'disponibility' => function ($attribute, $value, $onFailure) {
                try {
                    convert_to_excel_dates_to_date($value);
                } catch (\Exception $exception) {
                    $onFailure($attribute . ': ' . $exception->getMessage());
                }
            },
            'loading_place' => 'required|string',
            'note' => ['nullable', 'string'],
            'language_option_code_description' => ['required', 'integer', 'in:0,1'],
            'currency_iso_codification' => [
                function ($attribute, $value, $onFailure) {
                    try {
                        $this->exchangeValidationService->validateCurrencyCode($value ?? '');
                    } catch (\Exception $exception) {
                        $onFailure($attribute . ': ' . $exception->getMessage());
                    }
                },
                'required'
            ],
            'url_address' => ['nullable', 'string'],
            'media_path' => ['nullable', 'string'],
            'condition_type' => 'required|string|in:used,new,demo,new_registered|correctConditionType|bail',
            'vehicle_type' => 'required|string|in:Passenger,LCV,Truck|vpvuValid',
            'account_id' => ['nullable', 'alpha_num'],
            'body_type' => ['nullable', 'string'],
            'sku_number' => ['nullable', 'string'],
            'certification_code' => ['nullable', 'string'],
            'fuel_consumption_city' => ['nullable', 'numeric', 'gt:0'],
            'fuel_consumption_land' => ['nullable', 'numeric', 'gt:0'],
            'fuel_consumption_rating' => ['nullable', 'string'],
            'fuel_consumption_total' => ['nullable', 'numeric', 'gt:0'],
            'cylinders' => ['nullable', 'integer', 'gt:0'],
            'documents' => ['nullable', 'string'],
            'coc' => ['nullable', 'string'],
            'doors' => ['nullable', 'integer', 'gt:0'],
            'drive_type' => ['nullable', 'string'],
            'has_warranty' => 'in:0,1',
            'id' => ['nullable', 'externalId'],
            'model_group' => ['nullable', 'string'],
            'pollution_norm' => ['required', 'string', 'in:EURO0,EURO1,EURO2,EURO3,EURO4,EURO5,EURO6,EURO5A,EURO5B,EURO6A,EURO6B,EURO6C,EURO6D,EURO6+'],
            'price' => ['nullable', 'numeric'],
            'price_history' => ['nullable'],
            'price_new' => ['nullable', 'numeric'],
            'properties' => ['nullable', 'string'],
            'additional_properties' => ['nullable', 'string'],
            'seats' => ['nullable', 'integer'],
            'segmentation_id' => ['nullable', 'alpha_num'],
            'teaser' => ['nullable', 'string'],
            'videos' => ['nullable', 'string'],
            'weight' => ['required', 'integer', 'gt:0'],
        ];
    }
}
