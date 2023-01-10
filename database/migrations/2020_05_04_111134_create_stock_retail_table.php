<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateStockRetailTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('stock_retail', function (Blueprint $table) {
            $table->id();
            $table->string('vin')->nullable()->index();
            $table->string('body_color')->nullable()->index();
            $table->string('body_type')->nullable()->index();
            $table->string('car_number')->nullable()->index();
            $table->string('ccm')->nullable()->index();
            $table->string('certification_code')->nullable()->index();
            $table->integer('co2_emission')->nullable()->index();
            $table->decimal('consumption_rating_total')->nullable()->index();
            $table->string('consumption_rating')->nullable()->index();
            $table->integer('cylinders')->nullable()->index();
            $table->string('fuel_type')->nullable()->index();
            $table->integer('hp')->nullable()->index();
            $table->string('make')->nullable()->index();
            $table->string('model')->nullable()->index();
            $table->string('model_type')->nullable()->index();
            $table->integer('seats')->nullable()->index();
            $table->string('transmission_type')->nullable()->index();
            $table->string('vehicle_type')->nullable()->index();
            $table->integer('b2b_price')->nullable()->index();
            $table->string('condition_type')->nullable()->index();
            $table->integer('warranty_in_months')->nullable()->index();
            $table->boolean('is_metallic')->nullable()->index();
            $table->boolean('has_warranty')->nullable()->index();
            $table->string('status')->nullable()->index();
            $table->text('remarks')->nullable()->index();
            $table->string('interior_color')->nullable()->index();
            $table->string('interior_type')->nullable()->index();
            $table->integer('net_price')->nullable()->index();
            $table->char('net_price_currency', 3)->nullable()->index();
            $table->string('seller_phone')->nullable()->index();
            $table->integer('net_price_including_vat')->nullable()->index();
            $table->string('country')->nullable()->index();
            $table->string('seller_email')->nullable()->index();
            $table->date('in_stock_since')->nullable()->index();
            $table->jsonb('properties')->nullable();
            $table->jsonb('additional_properties')->nullable();
            $table->jsonb('standard_equipment')->nullable();
            $table->jsonb('optional_equipment')->nullable();
            $table->string('autoidat_fzkey')->nullable()->index();
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
        Schema::dropIfExists('stock_retail');
    }
}
