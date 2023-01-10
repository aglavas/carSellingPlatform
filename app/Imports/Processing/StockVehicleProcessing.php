<?php

namespace App\Imports\Processing;

use App\Service\ExchangeService;
use App\Exceptions\ImportColumnMissingException;
use App\VehicleParsingObject;
use Illuminate\Support\Facades\Auth;

class StockVehicleProcessing
{
    /**
     * @var ExchangeService
     */
    public $exchangeService;

    /**
     * @var string
     */
    public $country;

    /**
     * @var string
     */
    public $company;

    /**
     * UsedProcessing constructor.
     * @param ExchangeService $exchangeService
     */
    public function __construct(ExchangeService $exchangeService)
    {
        $this->exchangeService = $exchangeService;
        $this->country = auth()->user()->country;
        $this->company = auth()->user()->company;
    }

    /**
     * Process
     *
     * @param array $row
     * @return array
     * @throws ImportColumnMissingException
     */
    public function process(array $row)
    {
        $vehicleParsingObject = new VehicleParsingObject($row);

        if (!$this->country || !$this->company) {
            abort((new \Symfony\Component\HttpFoundation\Response())->setStatusCode(400,
                'User is missing country, company or both'));
        }

        if (config('app.url') === 'https://emilfrey.carmarket.io') {
            $optionCodeDescriptionEnglish = ($vehicleParsingObject->language_option_code_description == 0) ? google_translate($vehicleParsingObject->option_code_description) : $vehicleParsingObject->option_code_description;
        } else {
            $optionCodeDescriptionEnglish = $vehicleParsingObject->option_code_description;
        }

        try {
            $params = [
                "manufacturer_id" => $vehicleParsingObject->manufacturer_id,
                "origin" => $vehicleParsingObject->origin,
                "brand" => $vehicleParsingObject->brand,
                "model" => $vehicleParsingObject->model,
                "version_code" => $vehicleParsingObject->version_code,
                "version_description" => $vehicleParsingObject->version_description,
                "kw" => $vehicleParsingObject->kw,
                "cm3" => $vehicleParsingObject->cm3,
                "hp" => $vehicleParsingObject->hp,
                "fuel_type" => $vehicleParsingObject->fuel_type,
                "gearbox" => $vehicleParsingObject->gearbox,
                "km" => $vehicleParsingObject->km,
                "firstregistration" => convert_to_excel_dates_to_date($vehicleParsingObject->firstregistration),
                "color_code" => $vehicleParsingObject->color_code,
                "color_description" => $vehicleParsingObject->color_description,
                "interior" => $vehicleParsingObject->interior,
                "options_code" => $vehicleParsingObject->options_code,
                "option_code_description" => $vehicleParsingObject->option_code_description,
                "option_code_description_english" => $optionCodeDescriptionEnglish,
                "co2" => $vehicleParsingObject->co2,
                "b2b_price_ex_vat" => $vehicleParsingObject->b2b_price_ex_vat,
                "price_in_euro" => $this->handlePriceInEuro($vehicleParsingObject),
                "vat_deductible" => ($vehicleParsingObject->vat_deductible) ? 1 : 0,
                "damages_excl_vat_info" => $vehicleParsingObject->damages_excl_vat_info,
                "disponsibility" => convert_to_excel_dates_to_date($vehicleParsingObject->disponsibility),
                "language_option_code_description" => $vehicleParsingObject->language_option_code_description,
                "currency_iso_codification" => $vehicleParsingObject->currency_iso_codification,
                "url_address" => $vehicleParsingObject->url_address,
                "note" => $vehicleParsingObject->note,
                "media_path" => $vehicleParsingObject->media_path,
                "connectivity_partner_id" => $vehicleParsingObject->account_id,
                "body_type" => $vehicleParsingObject->body_type,
                "sku_number" => $vehicleParsingObject->sku_number,
                "certification_code" => $vehicleParsingObject->certification_code,
                "condition_type" => $vehicleParsingObject->condition_type,
                "fuel_consumption_city" => $vehicleParsingObject->fuel_consumption_city,
                "fuel_consumption_land" => $vehicleParsingObject->fuel_consumption_land,
                "fuel_consumption_rating" => $vehicleParsingObject->fuel_consumption_rating,
                "fuel_consumption_total" => $vehicleParsingObject->fuel_consumption_total,
                "cylinders" => $vehicleParsingObject->cylinders,
                "coc" => $vehicleParsingObject->coc,
                "documents" => $vehicleParsingObject->documents,
                "doors" => $vehicleParsingObject->doors,
                "drive_type" => $vehicleParsingObject->drive_type,
                "has_warranty" => $vehicleParsingObject->has_warranty,
                "external_id" => $this->processExternalId($vehicleParsingObject->id),
                "model_group" => $vehicleParsingObject->model_group,
                "pollution_norm" => $vehicleParsingObject->pollution_norm,
                "price" => $vehicleParsingObject->price,
                "price_history" => $vehicleParsingObject->price_history,
                "price_new" => $vehicleParsingObject->price_new,
                "properties" => $this->processProperties($vehicleParsingObject->properties),
                "additional_properties" => $this->processProperties($vehicleParsingObject->additional_properties),
                "seats" => $vehicleParsingObject->seats,
                "segmentation_id" => $vehicleParsingObject->segmentation_id,
                "seller" => $this->company->name . ', ' . $vehicleParsingObject->loading_place . ', ' . $this->country,
                "teaser" => $vehicleParsingObject->teaser,
                "type_name" => $vehicleParsingObject->brand . ', ' . $vehicleParsingObject->model . ', ' . $vehicleParsingObject->version_description . ', ' . $vehicleParsingObject->engine,
                "videos" => $vehicleParsingObject->videos,
                "weight" => $vehicleParsingObject->weight,
                "vehicle_type" => $vehicleParsingObject->vehicle_type,
                "country" => strtolower($this->country),
                "company" => $this->company->name,
                "company_id" => $this->company->id,
            ];
        } catch (\Exception $exception) {
            throw new ImportColumnMissingException($exception->getMessage());
        }

        return $params;
    }

    /**
     * Handle currency Iso
     *
     * @param $dataObject
     * @return float|int
     */
    private function handlePriceInEuro($dataObject)
    {
        $user = Auth::user();

        if ($user->stock_type === 'NC' && $user->import_types === 'I') {
            return 0;
        }

        return ($dataObject->currency_iso_codification != 'EUR') ? round( $this->exchangeService->convertEuroToCurrency($dataObject->b2b_price_ex_vat, strtoupper($dataObject->currency_iso_codification)), 2) : $dataObject->b2b_price_ex_vat;
    }

    /**
     * Process external id
     *
     * @param $externalId
     * @return array
     */
    private function processExternalId($externalId)
    {
        try {
            $externalIdArray = explode('=>', $externalId);

            $resultArray = [$externalIdArray[0] => $externalIdArray[1]];

            return $resultArray;
        } catch (\Exception $exception) {
            return null;
        }
    }

    /**
     * Process properties
     *
     * @param $properties
     * @return array|null
     */
    private function processProperties($properties)
    {
        try {
            $propertyArray = explode(',', $properties);

            return $propertyArray;
        } catch (\Exception $exception) {
            return null;
        }
    }
}
