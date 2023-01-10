<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateStockHrMbVansTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('stock_hr_mb_vans', function (Blueprint $table) {
            $table->id();
            $table->string('an')->index()->nullable();
            $table->string('vin')->index()->nullable();
            $table->string('model')->index()->nullable();
            $table->string('engine')->index()->nullable();
            $table->string('body_type')->index()->nullable();
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
        Schema::dropIfExists('stock_hr_mb_vans');
    }
}
