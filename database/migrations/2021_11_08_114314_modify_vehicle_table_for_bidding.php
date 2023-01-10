<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class ModifyVehicleTableForBidding extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('stock_vehicles', function (Blueprint $table) {
            $table->dropColumn('engine');
            $table->dropColumn('co2');
            $table->dropColumn('enquiry_status');
            $table->tinyInteger('pollution_norm_paid')->nullable();
            $table->string('coc')->nullable();
            $table->integer('co2_nedc')->nullable();
            $table->integer('co2_wltp')->nullable();
            $table->integer('cm3')->nullable();
            $table->integer('kw')->nullable();
            $table->integer('hp')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {

    }
}
