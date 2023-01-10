<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateStockPeugeotCitroenDsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('stock_peugeot_citroen_ds', function (Blueprint $table) {
            $table->id();
            $table->string('country', 2)->nullable();
            $table->string('brand')->index()->nullable();
            $table->string('model')->index()->nullable();
            $table->string('lcdv')->index()->nullable();
            $table->string('color')->index()->nullable();
            $table->string('interior')->index()->nullable();
            $table->text('options')->index()->nullable();
            $table->date('ecom')->nullable()->index();
            $table->string('caf')->index()->nullable();
            $table->string('vin')->index()->nullable();

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
        Schema::dropIfExists('stock_peugeot_citroen_ds');
    }
}
