<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateStockSwitzerlandTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('stock_switzerland', function (Blueprint $table) {
            $table->id();
            $table->string('mandant')->index()->nullable();
            $table->string('mandant_kurz')->index()->nullable();
            $table->date('key_date')->index()->nullable();
            $table->string('vin')->index()->nullable();
            $table->string('model_generation')->index()->nullable();
            $table->string('model')->index()->nullable();
            $table->string('body_type')->index()->nullable();
            $table->string('transmission_short')->index()->nullable();
            $table->string('transmission')->index()->nullable();
            $table->string('fuel')->index()->nullable();
            $table->string('equipment_short')->index()->nullable();
            $table->string('equipment_short_combination')->index()->nullable();
            $table->string('equipment')->index()->nullable();
            $table->string('equipment_combination')->index()->nullable();
            $table->string('body_color_code')->index()->nullable();
            $table->string('body_color')->index()->nullable();
            $table->string('interior_short')->index()->nullable();
            $table->string('interior')->index()->nullable();
            $table->string('location')->index()->nullable();
            $table->string('ownership')->index()->nullable();
            $table->string('consignment')->index()->nullable();
            $table->date('customs_on')->index()->nullable();
            $table->date('shipped_on')->index()->nullable();
            $table->date('port_on')->index()->nullable();
            $table->date('train_on')->index()->nullable();
            $table->date('pdi_on')->index()->nullable();
            $table->date('carrier_on')->index()->nullable();
            $table->text('variable_name')->index()->nullable();
            $table->text('variable_value')->index()->nullable();
            $table->boolean('duty_paid')->nullable();
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
        Schema::dropIfExists('stock_switzerland');
    }
}
