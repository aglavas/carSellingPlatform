<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateStockVehiclesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('stock_vehicles', function (Blueprint $table) {
            $table->id();

            ///Used cars

            $table->string('manufacturer_id')->unique()->index();
            $table->string('origin')->nullable()->index();
            $table->string('brand')->nullable()->index();
            $table->string('model')->nullable()->index();
            $table->string('version')->nullable()->index(); //model type
            $table->string('engine')->nullable()->index(); //hp, kw, ccm. KW is missing
            $table->string('fuel_type')->nullable()->index();
            $table->string('gearbox')->nullable()->index();
            $table->integer('km')->nullable()->index();
            $table->date('firstregistration')->nullable()->index();
            $table->string('color_code')->nullable()->index();
            $table->text('color_description')->nullable()->index();
            $table->text('options_code')->nullable()->index();
            $table->text('option_code_description')->nullable();
            $table->text('option_code_description_english')->nullable();
            $table->integer('co2')->nullable()->index();
            $table->decimal('b2b_price_ex_vat', 14)->nullable()->index();
            $table->decimal('price_in_euro', 14)->nullable()->index();
            $table->string('vat_deductible')->nullable()->index();
            $table->string('damages_excl_vat_info')->nullable()->index();
            $table->date('disponsibility')->nullable()->index();
            $table->string('language_option_code_description')->nullable()->index();
            $table->string('currency_iso_codification')->nullable()->index();
            $table->string('url_address')->nullable()->index();
            $table->text('note')->nullable()->index();
            $table->text('media_path')->nullable();

            ///Removed from current used cars

            ///vpvu
            ///enquiry_status

            ////////////FCA

            //version, check this!!
            //model_id - ???
            //equipment_description
            //interior
            //ident


            ////////////MERCEDES

            //an
            //bm
            //interior
            //upholstery

            ////////////OPEL

            //family  - remove
            //version - type name
            //interior
            //caf - vax code
            //order_number - remove
            //transaction_date  - remove

            ////////////PCDS

            //lcdv - type name.. Check this!!
            //interior
            //ecom -version Check this!!
            //caf
            //order_number
            //transaction_date


            ///////////////////

            $table->integer('connectivity_partner_id')->nullable()->index();
            $table->string('body_type')->nullable()->index();
            $table->string('sku_number')->nullable()->index();
            $table->string('certification_code')->nullable()->index();
            $table->string('condition_type')->nullable()->index();
            $table->string('fuel_consumption_city')->nullable()->index();
            $table->string('fuel_consumption_land')->nullable()->index();
            $table->text('fuel_consumption_rating')->nullable()->index();
            $table->string('fuel_consumption_total')->nullable()->index();
            $table->integer('cylinders')->nullable()->index();
            $table->text('documents')->nullable()->index();
            $table->integer('doors')->nullable()->index();
            $table->string('drive_type')->nullable()->index();
            $table->boolean('has_warranty')->nullable()->index();
            $table->json('external_id')->nullable();
            $table->string('model_group')->nullable()->index();
            $table->string('pollution_norm')->nullable()->index();
            $table->decimal('price', 14)->nullable()->index();
            $table->text('price_history')->nullable()->index();
            $table->decimal('price_new', 14)->nullable()->index();
            $table->jsonb('properties')->nullable()->index();
            $table->jsonb('additional_properties')->nullable();
            $table->integer('seats')->nullable()->index();
            $table->string('segmentation_id')->nullable()->index();
            $table->string('seller')->nullable()->index();  //Company name, Loading Place, Country
            $table->string('teaser')->nullable()->index();
            $table->string('type_name')->nullable()->index();
            $table->text('videos')->nullable();
            $table->integer('weight')->nullable()->index();
            $table->string('vehicle_type')->nullable(); //only new cars has this


            ////Autopopulate fields
            $table->string('country')->nullable()->index();
            $table->string('company')->nullable()->index();
            $table->integer('company_id')->nullable()->index();
            $table->string('enquiry_status')->nullable();
            $table->timestamps();

            ///Other notes
            ///
            /// Decide between brand and brand_id fields. Or both
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('stock_vehicles');
    }
}
