<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateStockFcaTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('stock_fca', function (Blueprint $table) {
            $table->id();
            $table->string('country', 2)->nullable();
            $table->string('brand_id')->index()->nullable();
            $table->string('model_name')->index()->nullable();
            $table->string('version')->index()->nullable();
            $table->string('model_id')->index()->nullable();
            $table->string('equipment')->index()->nullable();
            $table->text('equipment_description')->nullable();
            $table->text('options')->nullable();
            $table->text('options_description')->nullable();
            $table->string('color')->index()->nullable();
            $table->string('color_description')->index()->nullable();
            $table->string('interior')->index()->nullable();
            $table->string('co2')->index()->nullable();
            $table->string('vin')->index()->nullable();
            $table->string('ident')->index()->nullable();
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
        Schema::dropIfExists('stock_fca');
    }
}
