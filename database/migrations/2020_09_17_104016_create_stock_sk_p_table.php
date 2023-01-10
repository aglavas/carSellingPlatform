<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateStockSkPTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('stock_sk_p', function (Blueprint $table) {
            $table->id();
            $table->string('caf')->index()->nullable();
            $table->string('caf_status')->index()->nullable();
            $table->string('prod_month')->index()->nullable();
            $table->string('vin')->index()->nullable();
            $table->string('vin_status')->index()->nullable();
            $table->string('vin_usage')->index()->nullable();
            $table->string('vin_usage_add_on')->index()->nullable();
            $table->string('man_assign')->index()->nullable();
            $table->string('caf_block')->index()->nullable();
            $table->string('family')->index()->nullable();
            $table->string('caf_homolog_type')->index()->nullable();
            $table->string('caf_depol')->index()->nullable();
            $table->string('caf_co2')->index()->nullable();
            $table->string('sales_code')->index()->nullable();
            $table->string('model')->index()->nullable();
            $table->string('version')->index()->nullable();
            $table->string('lcdv')->index()->nullable();
            $table->string('color')->index()->nullable();
            $table->string('upholstery')->index()->nullable();
            $table->text('options')->nullable();
            $table->string('dealer_order_number')->index()->nullable();
            $table->string('order_status')->index()->nullable();
            $table->date('dealer_order_date')->index()->nullable();
            $table->string('dealer_number')->index()->nullable();
            $table->string('dealer_name')->index()->nullable();
            $table->string('dealer_town')->index()->nullable();
            $table->string('dealer_order_type')->index()->nullable();
            $table->string('vehicle_location')->index()->nullable();
            $table->string('factory')->index()->nullable();
            $table->date('production_date')->index()->nullable();
            $table->date('mad_forecast')->index()->nullable();
            $table->date('mad_date')->index()->nullable();
            $table->date('psa_invoice_date')->index()->nullable();
            $table->date('gefco_invoice_date')->index()->nullable();
            $table->string('pdi_status')->index()->nullable();
            $table->date('gefco_exit_date')->index()->nullable();
            $table->date('dealer_invoice_date')->index()->nullable();
            $table->string('dealer_invoice_number')->index()->nullable();
            $table->string('invoice_gross_amount')->index()->nullable();
            $table->string('customer_order_number')->index()->nullable();
            $table->date('contract_date')->index()->nullable();
            $table->string('customer_number')->index()->nullable();
            $table->string('customer_prename')->index()->nullable();
            $table->string('customer_surname')->index()->nullable();
            $table->string('customer_type')->index()->nullable();
            $table->string('fleet_type')->index()->nullable();
            $table->string('promo_code')->index()->nullable();
            $table->string('desired_del_week')->index()->nullable();
            $table->string('planned_del_week')->index()->nullable();
            $table->string('vehicle_notes')->index()->nullable();
            $table->string('eu_homologation_num')->index()->nullable();
            $table->string('type_variant_version')->index()->nullable();
            $table->string('tech_pass_num')->index()->nullable();
            $table->date('reg_date')->index()->nullable();
            $table->string('number_plate')->index()->nullable();
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
        Schema::dropIfExists('stock_sk_p');
    }
}
