<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateStockSkOpelTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('stock_sk_opel', function (Blueprint $table) {
            $table->id();
            $table->string('variety')->index()->nullable();
            $table->string('vin')->index()->nullable();
            $table->string('vehicle_state')->index()->nullable();
            $table->string('vehicle_state_description')->index()->nullable();
            $table->date('logatec_arrival_date')->index()->nullable();
            $table->string('siv_status')->index()->nullable();
            $table->string('siv_status_description')->index()->nullable();
            $table->string('is_flexable')->index()->nullable();
            $table->string('model_designation')->index()->nullable();
            $table->string('efit')->index()->nullable();
            $table->string('lcdv')->index()->nullable();
            $table->string('color')->index()->nullable();
            $table->string('color_designation')->index()->nullable();
            $table->string('trim')->index()->nullable();
            $table->string('trim_designation')->index()->nullable();
            $table->text('factory_options')->index()->nullable();
            $table->string('pdi_options')->index()->nullable();
            $table->string('version')->index()->nullable();
            $table->string('version_designation')->index()->nullable();
            $table->string('family')->index()->nullable();
            $table->string('family_desgination')->index()->nullable();
            $table->string('body')->index()->nullable();
            $table->string('body_designation')->index()->nullable();
            $table->string('engine')->index()->nullable();
            $table->string('engine_designation')->index()->nullable();
            $table->string('fuel')->index()->nullable();
            $table->string('fuel_designation')->index()->nullable();
            $table->string('transmission')->index()->nullable();
            $table->string('transmission_designation')->index()->nullable();
            $table->string('finishing')->index()->nullable();
            $table->string('finishing_designation')->index()->nullable();
            $table->string('country_conception')->index()->nullable();
            $table->string('fuel_type')->index()->nullable();
            $table->string('cat')->index()->nullable();
            $table->string('engine_number')->index()->nullable();
            $table->string('order_number_siv')->index()->nullable();
            $table->string('production_month')->index()->nullable();
            $table->date('actual_production_date')->index()->nullable();
            $table->date('first_declaration_date')->index()->nullable();
            $table->date('first_declaration_entry_date')->index()->nullable();
            $table->date('declaration_date')->index()->nullable();
            $table->date('declaration_entry_date')->index()->nullable();
            $table->date('declaration_bonus_date')->index()->nullable();
            $table->string('declaration_type')->index()->nullable();
            $table->date('eta_date')->index()->nullable();
            $table->string('order_number')->index()->nullable();
            $table->string('destination_country')->index()->nullable();
            $table->string('order_type')->index()->nullable();
            $table->string('order_type_description')->index()->nullable();
            $table->string('dealer_number_order')->index()->nullable();
            $table->string('dealer_shortname_order')->index()->nullable();
            $table->string('dealer_number_invoice')->index()->nullable();
            $table->string('dealer_shortname_invoice')->index()->nullable();
            $table->string('dealer_number_delivery')->index()->nullable();
            $table->string('dealer_shortname_delivery')->index()->nullable();
            $table->string('dealer_number_declaration')->index()->nullable();
            $table->string('dealer_shortname_declaration')->index()->nullable();
            $table->string('dealer_declaration_city')->index()->nullable();
            $table->string('dealer_number_stock')->index()->nullable();
            $table->string('dealer_shortname_stock')->index()->nullable();
            $table->string('dealer_stock_city')->index()->nullable();
            $table->string('saleszone_order_dealer')->index()->nullable();
            $table->string('saleszone_order_dealer_description')->index()->nullable();
            $table->string('saleszone_declaration_dealer')->index()->nullable();
            $table->string('saleszone_declaration_dealer_description')->index()->nullable();
            $table->string('order_state')->index()->nullable();
            $table->string('order_state_description')->index()->nullable();
            $table->string('pdi_status')->index()->nullable();
            $table->string('pdi_status_description')->index()->nullable();
            $table->date('order_date')->index()->nullable();
            $table->string('dealer_reference_number')->index()->nullable();
            $table->string('salesperson')->index()->nullable();
            $table->string('payment_method_description')->index()->nullable();
            $table->string('invoice_number')->index()->nullable();
            $table->date('invoice_date')->index()->nullable();
            $table->string('total_amount_included')->index()->nullable();
            $table->string('total_amount_included_currency')->index()->nullable();
            $table->string('factory_invoice_number')->index()->nullable();
            $table->date('factory_invoice_date')->index()->nullable();
            $table->string('pp_ship')->index()->nullable();
            $table->string('pp_ship_currency')->index()->nullable();
            $table->string('idle_days_importer')->index()->nullable();
            $table->string('idle_days_dealer')->index()->nullable();
            $table->string('idle_days_demo')->index()->nullable();
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
        Schema::dropIfExists('stock_sk_opel');
    }
}
