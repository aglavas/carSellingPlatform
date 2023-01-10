<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateStockSiCTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('stock_si_c', function (Blueprint $table) {
            $table->id();
            $table->string('vin')->index()->nullable();
            $table->string('vehicle_state')->index()->nullable();
            $table->date('logatec_arrival_date')->index()->nullable();
            $table->string('siv_status_desc')->index()->nullable();
            $table->string('model_designation')->index()->nullable();
            $table->string('efit')->index()->nullable();
            $table->string('lcdv')->index()->nullable();
            $table->string('color')->index()->nullable();
            $table->string('color_design')->index()->nullable();
            $table->string('trim')->index()->nullable();
            $table->string('trim_desig')->index()->nullable();
            $table->string('factory_options')->index()->nullable();
            $table->string('pdi_options')->index()->nullable();
            $table->string('version')->index()->nullable();
            $table->string('version_desig')->index()->nullable();
            $table->string('family')->index()->nullable();
            $table->string('family_desig')->index()->nullable();
            $table->string('body')->index()->nullable();
            $table->string('body_desig')->index()->nullable();
            $table->string('engine')->index()->nullable();
            $table->string('engine_desig')->index()->nullable();
            $table->string('fuel')->index()->nullable();
            $table->string('fuel_desig')->index()->nullable();
            $table->string('transmission')->index()->nullable();
            $table->string('transmission_desig')->index()->nullable();
            $table->string('finishing')->index()->nullable();
            $table->string('finishing_desig')->index()->nullable();
            $table->string('country_conception')->index()->nullable();
            $table->string('fuel_type')->index()->nullable();
            $table->string('cat')->index()->nullable();
            $table->string('engine_number')->index()->nullable();
            $table->string('order_number_siv')->index()->nullable();
            $table->string('production_month')->index()->nullable();
            $table->date('actual_production_date')->index()->nullable();
            $table->string('dealer_shortname_order')->index()->nullable();
            $table->string('order_state_descr')->index()->nullable();
            $table->string('pdi_status_descr')->index()->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('stock_si_c');
    }
}
