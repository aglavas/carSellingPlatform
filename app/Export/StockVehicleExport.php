<?php

namespace App\Export;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Collection;

class StockVehicleExport
{
    /**
     * @var Collection
     */
    private $users;

    /**
     * StockUsedCentralEuropeExport constructor.
     * @param Collection $collection
     */
    public function __construct(Collection $collection)
    {
        $this->users = $collection;
    }

    /**
     * Prepare export data
     *
     * @param Model $model
     * @return array
     * @throws \Exception
     */
    public function prepareExport(Model $model)
    {
        $resultArray = [
            'Manufacturer Id' => $model->manufacturer_id,
            'Origin' => $model->origin,
            'Brand' => $model->brand,
            'Model' => $model->model,
            'Version' => $model->version_description,
            'Cm3' => $model->cm3,
            'Kw' => $model->kw,
            'Hp' => $model->hp,
            'Fuel Type' => $model->fuel_type,
            'Gearbox' => $model->gearbox,
            'Km' => $model->km,
            'First Registration Year' => $model->firstRegistrationYear,
            'Color Code' => $model->color_code,
            'Color Description' => $model->color_description,
            'Options Code' => $model->options_code,
            'Options Code Description' => $model->option_code_description,
            'Options Code Description English' => $model->option_code_description_english,
            'Co2' => $model->co2,
            'B2b Price Ex Vat' => number_format($model->b2b_price_ex_vat, 2, ',', ''),
            'Price In Euro' => $model->price_in_euro,
            'Vat Deductible' => $model->vat_deductible,
            'Damages Excl Vat Info' => $model->damages_excl_vat_info,
            'Disponibility' => (is_null($model->disponibility) ? '️✔️' : $model->disponibility->format('Y-m-d')),
            'Currency' => $model->currency_iso_codification,
            'Url Address' => $model->url_address,
            'Note' => $model->note,
            'Body Type' => $model->body_type,
            'Sku Number' => $model->sku_number,
            'Condition Type' => $model->condition_type,
            'Fuel Consumption City' => $model->fuel_consumption_city,
            'Fuel Consumption Land' => $model->fuel_consumption_land,
            'Fuel Consumption Rating' => $model->fuel_consumption_rating,
            'Fuel Consumption Total' => $model->fuel_consumption_total,
            'Cylinders' => $model->cylinders,
            'Documents' => $model->documents,
            'Doors' => $model->doors,
            'Drive Type' => $model->drive_type,
            'Has Warranty' => $model->has_warranty,
            'Model Group' => $model->model_group,
            'Pollution Norm' => $model->pollution_norm,
            'Coc Document' => $model->coc,
            'Price' => $model->price,
            'Price History' => $model->price_history,
            'Price New' => $model->price_new,
            'Properties' => implode(',', $model->properties),
            'Additional Properties' => implode(',', $model->additional_properties),
            'Seats' => $model->seats,
            'Seller' => $model->seller,
            'Teaser' => $model->teaser,
            'Type Name' => $model->type_name,
            'Video' => $model->videos,
            'Weight' => $model->weight,
            'Vehicle Type' => $model->vehicle_type,
            'Country' => convert_iso3166_to_country($model->country),
            'Company' => $model->company,
            'Exchange Rate' => ($model->price_in_euro > 0)? round($model->b2b_price_ex_vat / $model->price_in_euro, 2) : '',
            'Contact1' => $this->getContact(0, $model->country, $model->company),
            'Contact2' => $this->getContact(1, $model->country, $model->company),
            'Contact3' => $this->getContact(2, $model->country, $model->company)
        ];

        $resultArray = array_map(
            function($v) { if ($v == null) $v = ''; return $v; },
            $resultArray
        );

        return $resultArray;
    }

    /**
     * Get contact out of collection
     *
     * @param $take
     * @param $country
     * @param $company
     * @return string
     */
    private function getContact(int $take, string $country, string $company)
    {
        $filteredCollection = $this->users->where('country', strtoupper($country))->where('company.name', $company)->values();

        $user = $filteredCollection->get($take);

        if ($user) {
            return $user->email . ', ' . $user->function_description . ', Tel: ' . $user->telephone . ', Mob: ' . $user->mobile;
        }
        return '';
    }
}
