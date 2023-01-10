<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateStockMercedesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('stock_mercedes', function (Blueprint $table) {
            $table->id();
            $table->string('country', 2)->nullable();
            $table->string('brand')->index()->nullable();
            $table->string('an')->index()->nullable();
            $table->string('bm')->index()->nullable();
            $table->string('color')->index()->nullable();
            $table->string('interior')->index()->nullable();
            $table->string('upholstery')->index()->nullable();
            $table->text('options')->index()->nullable();
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
        Schema::dropIfExists('stock_mercedes');
    }
}
