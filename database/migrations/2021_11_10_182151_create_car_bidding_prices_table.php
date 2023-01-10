<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateCarBiddingPricesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('car_bidding_prices', function (Blueprint $table) {
            $table->id();
            $table->string('manufacturer_id')->index();
            $table->integer('price_id')->nullable();
            $table->integer('client_id')->nullable();
            $table->string('country_from')->nullable();
            $table->string('country_to')->nullable();
            $table->decimal('price', 20)->nullable()->default(0.00);
            $table->decimal('bpm_outcome', 20)->nullable()->default(0.00);
            $table->string('currency')->nullable();
            $table->integer('session_token_id')->nullable();
            $table->integer('status')->nullable();
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
        Schema::dropIfExists('car_bidding_prices');
    }
}
