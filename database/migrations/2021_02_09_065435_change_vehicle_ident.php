<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class ChangeVehicleIdent extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('wishlist_items', function (Blueprint $table) {
            $table->dropColumn('vin');
            $table->string('vehicle_ident')->nullable(false)->index();
        });

        Schema::table('transactions', function (Blueprint $table) {
            $table->dropColumn('vin');
            $table->string('vehicle_ident')->nullable(false)->index();
        });

        Schema::table('cart_items', function (Blueprint $table) {
            $table->dropColumn('vehicle_id');
            $table->string('vehicle_ident')->nullable(false)->index();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        //
    }
}
