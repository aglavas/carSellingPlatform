<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

class CreateUnifiedCarView extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        DB::beginTransaction();

        DB::unprepared(<<<'SQL'
            drop view if exists unified_view ;
                CREATE OR REPLACE VIEW public.unified_view AS
                
                SELECT
                    row_number() OVER () AS id,
                    *
                FROM (
                    SELECT country as country,
                           company as company,
                           caf as vehicle_ident,
                           'App\StockPeugeotCitroenDs' as vehicle_type,
                           country as origin,
                           brand(brand_id) as brand,
                           vpvu as vpvu,
                           model as model,
                           color as color,
                           options as options,
                           enquiry_status as enquiry_status,
                           created_at
                        FROM stock_peugeot_citroen_ds
                    UNION All
                    SELECT country as country,
                           company as company,
                           caf as vehicle_ident,
                           'App\StockOpel' as vehicle_type,
                           country as origin,
                           brand(brand_id) as brand,
                           vpvu as vpvu,
                           model_name as model,
                           color as color,
                           options as options,
                           enquiry_status as enquiry_status,
                           created_at
                        FROM stock_opel
                    UNION All
                    SELECT country,
                           company,
                           ident as vehicle_ident,
                           'App\StockFCA' as vehicle_type,
                           country as origin,
                           brand(brand_id) as brand,
                           vpvu,
                           model_name as model,
                           color,
                           options,
                           enquiry_status as enquiry_status,
                           created_at
                        FROM stock_fca
                    UNION All
                    SELECT country,
                           company,
                           an as vehicle_ident,
                           'App\StockMercedes' as vehicle_type,
                           country as origin,
                           brand(brand_id) as brand,
                           vpvu,
                           model as model,
                           color,
                           options,
                           enquiry_status as enquiry_status,
                           created_at
                        FROM stock_mercedes
                    UNION All
                    SELECT country,
                           company,
                           vin as vehicle_ident,
                           'App\StockUsedCentralEurope' as vehicle_type,
                           origin,
                           brand as brand,
                           vpvu,
                           model,
                           color_code as color,
                           options_code as options,
                           enquiry_status as enquiry_status,
                           created_at
                        FROM stock_retail_central_europe
                ) AS unified_view
        SQL);

        DB::commit();
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('unified_car_view');
    }
}
