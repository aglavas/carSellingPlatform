<?php

namespace Database\Factories;

use App\StockVehicle;
use Illuminate\Database\Eloquent\Factories\Factory;
use App\Company;
use Illuminate\Support\Str;

class StockVehicleFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = StockVehicle::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        $company = Company::all()->random(1)->first();

        $brand = $this->faker->randomElement(['ALFA ROMEO', 'MERCESES-BENZ', 'BMW', 'CITROEN', 'TOYOTA']);
        $model = $this->faker->randomElement(['LEVORG', 'BMW I3 120AH', 'V90', 'AVENSIS', 'GOLF SPORTSVAN']);
        $version = $this->faker->randomElement([
            'AUDI A4 AVANT KARAVAN 2,0 TDI',
            'JEEP CHEROKEE ZAPRT TERENSKI 2.2 MULTIJET 16V CA FWD',
            'V90',
            'AVENSIS',
            'GOLF SPORTSVAN',
            'CHEVROLET ORLANDO KARAVAN 2.0 DT 16V',
            'HYBRID,CZ,1MAJ,TREND,AT',
        ]);

        return [
            'manufacturer_id' => Str::random(19),
            'origin' => $this->faker->randomElement(['CZ', 'SK', 'SI', 'HU', 'HR', 'RS', 'CH', 'FR', 'NL', 'DE']),
            'brand' => $brand,
            'model' => $model,
            'version_description' => $version,
            'fuel_type' => $this->faker->randomElement([
                'Gasoline',
                'Diesel',
                'Hybrid',
                'Electric',
                'LPG',
                'Other',
                'Fuels',
                'Alcohol',
                'Cryogenic',
                'Waterstof'
            ]),
            'gearbox' => $this->faker->randomElement([
                'A',
                'M',
            ]),
            'km' => $this->faker->randomDigitNotNull,
            'firstregistration' => $this->faker->date(),
            'color_code' => $this->faker->safeColorName,
            'color_description' => $this->faker->text,
            'options_code' => $this->faker->safeColorName,
            'option_code_description' => $this->faker->text,
            'option_code_description_english' => $this->faker->text,
            'b2b_price_ex_vat' => $this->faker->randomDigitNotNull,
            'price_in_euro' => $this->faker->randomDigitNotNull,
            'vat_deductible' => $this->faker->boolean,
            'damages_excl_vat_info' => $this->faker->randomDigitNotNull,
            'disponsibility' => $this->faker->date(),
            'language_option_code_description' => 0,
            'currency_iso_codification' => 'EUR',
            'url_address' => $this->faker->url,
            'note' => $this->faker->text,
            'media_path' => $this->faker->url,
            'connectivity_partner_id' => $this->faker->randomDigitNotNull,
            'body_type' => $this->faker->randomElement([
                'Bus',
                'Kombi',
                'Limousine',
                'SUV',
            ]),
            'sku_number' => $this->faker->randomDigitNotNull,
            'certification_code' => $this->faker->regexify('[A-Za-z0-9]{20}'),
            'condition_type' => $this->faker->randomElement([
                'new',
                'used'
            ]),
            'fuel_consumption_city' => $this->faker->randomFloat(2, 5, 15),
            'fuel_consumption_land' => $this->faker->randomFloat(2, 5, 15),
            'fuel_consumption_rating' => $this->faker->text,
            'fuel_consumption_total' => $this->faker->randomFloat(2, 5, 15),
            'cylinders' => $this->faker->randomNumber(),
            'documents' => $this->faker->text,
            'doors' => $this->faker->randomNumber(),
            'drive_type' => $this->faker->randomElement([
                'Front wheel drive',
                'Rear wheel drive',
                'All-wheel drive'
            ]),
            'has_warranty' => $this->faker->boolean,
            'external_id' => [
                'autoscout_id' => $this->faker->randomDigitNotNull
            ],
            'model_group' => null,
            'pollution_norm' => $this->faker->randomElement([
                'EURO0',
                'EURO1',
                'EURO2',
                'EURO3',
                'EURO4',
                'EURO5',
                'EURO6',
                'EURO5A',
                'EURO5B',
                'EURO6A',
                'EURO6B',
                'EURO6C',
                'EURO6D',
                'EURO6+',
            ]),
            'price' => $this->faker->randomDigitNotNull,
            'price_history' => $this->faker->randomDigitNotNull . "," . $this->faker->randomDigitNotNull,
            'price_new' => $this->faker->randomDigitNotNull,
            'properties' => [],
            'additional_properties' => [],
            'seats' => $this->faker->randomDigitNotNull,
            'segmentation_id' => $this->faker->randomDigitNotNull,
            'seller' => $company->name . ', ' . $this->faker->city . ', ' . $this->faker->country,
            'teaser' => '',
            'type_name' => "$brand, $model, $version",
            'videos' => $this->faker->url,
            'weight' => $this->faker->randomDigitNotNull,
            'vehicle_type' => $this->faker->randomElement([
                'Passenger',
                'LCV',
                'Truck',
            ]),
            'country' => $this->faker->country,
            'company' => $company->name,
            'company_id' => $company->id,
            'coc' => 'https://templatelab.com/wp-content/uploads/2017/08/certificate-of-conformance-02.jpg',
            'co2' => $this->faker->randomDigitNotNull,
            'cm3' => $this->faker->randomDigitNotNull,
            'kw' => $this->faker->randomDigitNotNull,
            'hp' => $this->faker->randomDigitNotNull,
            'interior' => $this->faker->randomDigitNotNull,
            'version_code' => $this->faker->randomDigitNotNull,
        ];
    }
}

