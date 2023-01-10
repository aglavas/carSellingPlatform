<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class VehicleSettings extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('vehicle_settings', function (Blueprint $table) {
            $table->id();
            $table->string('manufacturer_id')->unique()->index();
            $table->string('enquiry_status')->nullable();
            $table->string('bidding_status')->nullable();
            $table->integer('bidding_token_id')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('vehicle_settings');
    }
}
