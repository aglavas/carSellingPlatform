<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddLastPriceToVehicleSettings extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('vehicle_settings', function (Blueprint $table) {
            $table->decimal('b2b_price_ex_vat', 14)->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('vehicle_settings', function (Blueprint $table) {
            $table->dropColumn('b2b_price_ex_vat');
        });
    }
}
