<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateStockCzPsaTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('stock_cz_psa', function (Blueprint $table) {
            $table->id();
            $table->string('brand')->index()->nullable();
            $table->string('family')->index()->nullable();
            $table->string('family_name')->index()->nullable();
            $table->string('family_code')->index()->nullable();
            $table->string('model_name')->index()->nullable();
            $table->string('version')->index()->nullable();
            $table->string('interior')->index()->nullable();
            $table->string('color')->index()->nullable();
            $table->string('vpvu')->index()->nullable();
            $table->string('caf')->index()->nullable();
            $table->string('order_number')->index()->nullable();
            $table->string('vin')->index()->unique();
            $table->integer('importer_stock_age')->index()->nullable();
            $table->string('importer_stock_age_group')->index()->nullable();
            $table->text('options')->index()->nullable();
            $table->integer('co2')->index()->nullable();
            $table->tinyInteger('is_emission');
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
        Schema::dropIfExists('stock_cz_psa');
    }
}
