<?php

namespace App\Console\Commands;

use App\Brand;
use App\CartItem;
use App\Company;
use App\Enquiry;
use App\StockFCA;
use App\StockMercedes;
use App\StockOpel;
use App\StockPeugeotCitroenDs;
use App\StockUsedCentralEurope;
use App\StockVehicle;
use App\Transaction;
use Illuminate\Console\Command;
use PDOException;

class MigrateVehiclesToUnifiedStructure extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'vehicle:migrate:new:structure';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Migrate all vehicles to unified table base on INSIDE feed';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * @todo enquiry status
     *
     * Execute the console command.
     *
     * @return int
     */
    public function handle()
    {
        $usedCarCollection = StockUsedCentralEurope::all();

        foreach ($usedCarCollection as $usedCar) {
            $company = Company::where('name', $usedCar->company)->get()->first();

            StockVehicle::create([
                'manufacturer_id' => $usedCar->vin,
                'origin' => $usedCar->origin,
                'brand' => $usedCar->brand,
                'model' => $usedCar->model,
                'version_description' => $usedCar->version,
                'engine' => $usedCar->engine,
                'fuel_type' => $usedCar->fuel_type,
                'gearbox' => $usedCar->gearbox,
                'km' => $usedCar->km,
                'firstregistration' => $usedCar->firstregistration,
                'color_code' => $usedCar->color_code,
                'color_description' => $usedCar->color_description,
                'options_code' => $usedCar->options_code,
                'option_code_description' => $usedCar->option_code_description,
                'option_code_description_english' => $usedCar->option_code_description_english,
                'co2' => $usedCar->co2,
                'b2b_price_ex_vat' => $usedCar->b2b_price_ex_vat,
                'price_in_euro' => $usedCar->price_in_euro,
                'vat_deductible' => $usedCar->vat_deductible,
                'damages_excl_vat_info' => $usedCar->damages_excl_vat_info,
                'disponsibility' => $usedCar->disponsibility,
                'language_option_code_description' => $usedCar->language_option_code_description,
                'currency_iso_codification' => $usedCar->currency_iso_codification,
                'url_address' => $usedCar->url_address,
                'note' => $usedCar->note,
                'media_path' => $usedCar->media_path,
                'condition_type' => 'used',
                'seller' => $usedCar->company . ', ' . $usedCar->loading_place . ', ' . $usedCar->country,
                'type_name' => $usedCar->brand . ', ' . $usedCar->model . ', ' . $usedCar->version . ', ' . $usedCar->engine,
                'country' => $usedCar->country,
                'company' => $usedCar->company,
                'company_id' => $company->id,
                'enquiry_status' => $usedCar->enquiry_status,
            ]);
        }

        $this->info("Used cars migrated.");

        $mercedesCollection = StockMercedes::all();

        foreach ($mercedesCollection as $mercedes) {
            $brand = Brand::find($mercedes->brand_id);

            StockVehicle::create([
                'manufacturer_id' => $mercedes->an,
                'brand' => $brand->name,
                'model' => $mercedes->model,
                'color_code' => $mercedes->color,
                'options_code' => $mercedes->options,
                'condition_type' => 'new',
                'seller' => $mercedes->company . ', ' . $mercedes->country,
                'country' => $mercedes->country,
                'company' => $mercedes->company,
                'company_id' => $mercedes->company_id,
                'type_name' => $brand->name . ', ' . $mercedes->model,
                'vehicle_type' => $mercedes->vehicle_type,
                'enquiry_status' => $mercedes->enquiry_status,
            ]);
        }

        $this->info("Mercedes migrated.");

        $opelCollection = StockOpel::all();

        foreach ($opelCollection as $opel) {
            $brand = Brand::find($opel->brand_id);

            StockVehicle::create([
                'manufacturer_id' => $opel->caf,
                'brand' => $brand->name,
                'model' => $opel->model_name,
                'version_description' => $opel->version,
                'color_code' => $opel->color,
                'options_code' => $opel->options,
                'co2' => $opel->co2,
                'condition_type' => 'new',
                'seller' => $opel->company . ', ' . $opel->country,
                'type_name' => $brand->name . ', ' . $opel->model_name . ', ' . $opel->version,
                'country' => $opel->country,
                'company' => $opel->company,
                'company_id' => $opel->company_id,
                'vehicle_type' => $opel->vehicle_type,
                'enquiry_status' => $opel->enquiry_status,
            ]);
        }

        $this->info("Opel migrated.");

        $fcaCollection = StockFCA::all();

        foreach ($fcaCollection as $fca) {
            $brand = Brand::find($fca->brand_id);

            try {
                StockVehicle::create([
                    'manufacturer_id' => $fca->ident,
                    'brand' => $brand->name,
                    'model' => $fca->model_name,
                    'version_description' => $fca->version,
                    'model_group' => $fca->model_id, //check this
                    'color_code' => $fca->color,
                    'color_description' => $fca->color_description,
                    'options_code' => $fca->options,
                    'option_code_description' => $fca->equipment . ', ' . $fca->equipment_descroiption . ', ' . $fca->options_description,
                    'co2' => $fca->co2,
                    'condition_type' => 'new',
                    'seller' => $fca->company . ', ' . $fca->country,
                    'type_name' => $brand->name . ', ' . $fca->model_name . ', ' . $fca->version,
                    'country' => $fca->country,
                    'company' => $fca->company,
                    'company_id' => $fca->company_id,
                    'vehicle_type' => $fca->vehicle_type,
                    'enquiry_status' => $fca->enquiry_status,
                ]);
            } catch (PDOException $exception) {
                var_dump($exception->getMessage());
                continue;
            }
        }

        $this->info("Fca migrated.");

        $pcdsCollection = StockPeugeotCitroenDs::all();

        foreach ($pcdsCollection as $pcds) {
            $brand = Brand::find($pcds->brand_id);

            try {
                StockVehicle::create([
                    'manufacturer_id' => $pcds->caf,
                    'brand' => $brand->name,
                    'model' => $pcds->model,
                    'color_code' => $pcds->color,
                    'options_code' => $pcds->options,
                    'condition_type' => 'new',
                    'seller' => $pcds->company . ', ' . $pcds->country,
                    'type_name' => $brand->name . ', ' . $pcds->model,
                    'country' => $pcds->country,
                    'company' => $pcds->company,
                    'company_id' => $pcds->company_id,
                    'vehicle_type' => $pcds->vehicle_type,
                    'enquiry_status' => $pcds->enquiry_status,
                ]);
            } catch (PDOException $exception) {
                var_dump($exception->getMessage());
                continue;
            }
        }

        $this->info("Pcd migrated.");

        Transaction::truncate();
        Enquiry::truncate(); //add cascade
        CartItem::truncate();
    }
}
