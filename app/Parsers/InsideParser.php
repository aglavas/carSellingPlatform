<?php

namespace App\Parsers;

use App\Contracts\Json\ParserContract;
use Illuminate\Support\Arr;
use Illuminate\Support\Facades\Auth;

class InsideParser implements ParserContract
{
    /**
     * @var \Illuminate\Config\Repository|mixed
     */
    public $csvFolder;

    /**
     * @var array
     */
    private $columns = [
        'manufacturer_id' => 'ChassisCode',
        'origin' => 'CountryOrigin',
        'brand' => 'MakeText',
        'model' => 'ModelText',
        'version_description' => 'ModelTypeText',
        'engine' => ['Ccm', 'Hp'],
        'fuel_type' => 'FuelTypeText',
        'gearbox' => 'TransmissionTypeText',
        'km' => 'Km',
        'firstregistration' => ['FirstRegMonth', 'FirstRegYear'],
        'color_code' => 'BodyColorCode',
        'color_description' => 'BodyColorText',
        'options_code' => 'options_code', // missing
        'option_code_description' => 'Equipment',
        'co2' => 'Co2Emission',
        'b2b_price_ex_vat' => 'B2bPriceExVat',
        'vat_deductible' => 'VatDeductible',
        'damages_excl_vat_info' => 'WarrantyDescription',
        'disponsibility' => 'Availability',
        'loading_place' => 'Seller',
        'language_option_code_description' => 'language_option_code_description', //set to 0
        'currency_iso_codification' => 'CurrencyIso',
        'url_address' => 'URLmarketplace',
        'note' => 'Comments',
        'media_path' => 'Images',
        'account_id' => 'AccountId',
        'body_type' => 'BodyTypeText',
        'sku_number' => 'CarNumber',
        'certification_code' => 'CertificationCode',
        'condition_type' => 'ConditionTypeText',
        'fuel_consumption_city' => 'ConsumptionCity',
        'fuel_consumption_land' => 'ConsumptionLand',
        'fuel_consumption_rating' => 'ConsumptionRatingText',
        'fuel_consumption_total' => 'ConsumptionTotal',
        'cylinders' => 'Cylinders',
        'documents' => 'Documents',
        'doors' => 'Doors',
        'drive_type' => 'DriveTypeText',
        'has_warranty' => 'HasWarranty',
        'external_id' => 'Id',
        'model_group' => 'ModelGroupText',
        'pollution_norm' => 'PollutionNormTypeText',
        'price' => 'Price',
        'price_history' => ['PriceHistory'],
        'price_new' => 'PriceNew',
        'properties' => 'Properties',
        'additional_properties' => 'AdditionalProperties',
        'seats' => 'Seats',
        'segmentation_id' => 'SegmentationId',
        'teaser' => 'Teaser',
        'videos' => 'Videos',
        'weight' => 'Weight',
        'vehicle_type' => 'VehicleType',
    ];

    /**
     * Parse request data
     *
     * @param array $array
     * @return array|mixed
     */
    public function parse(array $array)
    {
        $convertedArray = [];

        foreach ($this->columns as $key => &$value) {

            if ($key === 'option_code_description') {
                $result =  $this->processMultiDimensionalArray($array['Equipment']);

                $convertedArray[$key] = $result;
            } elseif ($key === 'firstregistration') {
                $convertedArray[$key] = $array['FirstRegMonth'] .'/1/'. $array['FirstRegYear'];
            } elseif ($key === 'loading_place') {
                if (isset($array['Seller']['Street']) && isset($array['Seller']['Zip']) && isset($array['Seller']['City'])) {
                    $convertedArray[$key] = $array['Seller']['Street'] . ', ' . $array['Seller']['Zip'] . ', ' . $array['Seller']['City'];
                }
            } elseif ($key === 'condition_type') {
                $convertedArray[$key] = strtolower($array['ConditionTypeText']);
            } elseif ($key === 'media_path') {
                $convertedArray[$key] = implode($array['Images']['Original']);
            } elseif ($key === 'documents') {
                $convertedArray[$key] = implode($array['Documents']);
            } elseif ($key === 'properties') {
                $convertedArray[$key] = implode(',', $array['Properties']);
            } elseif ($key === 'additional_properties') {
                $convertedArray[$key] = implode(',', $array['AdditionalProperties']);
            } elseif ($key === 'external_id') {
                $id = $array['Id'];

                $convertedArray['id'] = "Inside => $id";
            } elseif ($key === 'videos') {
                $convertedArray[$key] = implode($array['Videos']);
            } elseif (is_array($value)) {
                if (in_array('user|country', $value)) {
                    $arrayKey = array_search('user|country', $value);

                    $value[$arrayKey] = Auth::user()->country;

                    $convertedArray[$key] = implode(' ', $value);
                } else {
                    $convertedArray[$key] = implode(' ', $value);
                }
            } else {
                $fieldValue = null;

                if (isset($array[$value])) {
                    $fieldValue = $array[$value];
                }

                $convertedArray[$key] = $fieldValue;
            }
        }

        $convertedArray['language_option_code_description'] = 0;
        $convertedArray['currency_iso_codification'] = 'EUR';

        return $convertedArray;
    }

    /**
     * Process multidimensional file
     *
     * @param $array
     * @return string
     */
    private function processMultiDimensionalArray($array)
    {
        $flattenArray = Arr::dot($array);

        $stringValue = '';

        foreach ($flattenArray as $item) {
            if (is_string($item)) {
                $stringValue = $stringValue . $item . ',';
            }
        }

        return $stringValue;
    }
}
