<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class ChangeConnectivityPartnerIdToString extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('stock_vehicles', function (Blueprint $table) {
            $table->string('connectivity_partner_id')->change();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('stock_vehicles', function (Blueprint $table) {
            $table->integer('connectivity_partner_id')->change();
        });
    }
}
