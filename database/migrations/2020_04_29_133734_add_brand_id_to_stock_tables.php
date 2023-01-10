<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddBrandIdToStockTables extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('stock_mercedes', function (Blueprint $table) {
            $table->integer('brand_id');
            $table->dropColumn('brand');
        });
        Schema::table('stock_peugeot_citroen_ds', function (Blueprint $table) {
            $table->integer('brand_id');
            $table->dropColumn('brand');
        });
        Schema::table('stock_opel', function (Blueprint $table) {
            $table->integer('brand_id');
            $table->dropColumn('brand');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('stock_mercedes', function (Blueprint $table) {
            $table->string('brand')->nullable();
            $table->dropColumn('brand_id');
        });
        Schema::table('stock_peugeot_citroen_ds', function (Blueprint $table) {
            $table->string('brand')->nullable();
            $table->dropColumn('brand_id');
        });
        Schema::table('stock_opel', function (Blueprint $table) {
            $table->string('brand')->nullable();
            $table->dropColumn('brand_id');
        });
    }
}
