<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateStockUsedCentralEuropeTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('stock_retail_central_europe', function (Blueprint $table) {
            $table->id();
            $table->string('vin')->nullable()->index();
            $table->string('origin')->nullable()->index();
            $table->string('brand')->nullable()->index();
            $table->string('vpvu')->nullable()->index();
            $table->string('model')->nullable()->index();
            $table->string('version')->nullable()->index();
            $table->string('engine')->nullable()->index();
            $table->string('fuel_type')->nullable()->index();
            $table->string('gearbox')->nullable()->index();
            $table->integer('km')->nullable()->index();
            $table->date('firstregistration')->nullable()->index();
            $table->string('color_code')->nullable()->index();
            $table->string('color_description')->nullable()->index();
            $table->text('options_code')->nullable();
            $table->text('option_code_description')->nullable();
            $table->integer('co2')->nullable()->index();
            $table->decimal('b2b_price_ex_vat')->nullable()->index();
            $table->string('vat_deductible')->nullable()->index();
            $table->string('damages_excl_vat_info')->nullable()->index();
            $table->date('disponibility')->nullable()->index();
            $table->string('loading_place')->nullable()->index();
            $table->string('note')->nullable()->index();
            $table->string('language_option_code_description')->nullable()->index();
            $table->string('currency_iso_codification')->nullable()->index();
            $table->string('url_address')->nullable()->index();
            $table->string('country')->nullable()->index();
            $table->string('company')->nullable()->index();
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
        Schema::dropIfExists('stock_retail_central_europe');
    }
}
