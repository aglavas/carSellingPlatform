<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddNewColumnsToStockListTables extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('stock_peugeot_citroen_ds', function (Blueprint $table) {
            $table->string('vehicle_type')->nullable();
            $table->integer('uploader_id')->nullable();
        });

        Schema::table('stock_retail_central_europe', function (Blueprint $table) {
            $table->integer('uploader_id')->nullable();
        });

        Schema::table('stock_mercedes', function (Blueprint $table) {
            $table->string('vehicle_type')->nullable();
            $table->integer('uploader_id')->nullable();
        });

        Schema::table('stock_opel', function (Blueprint $table) {
            $table->string('vehicle_type')->nullable();
            $table->integer('uploader_id')->nullable();
        });

        Schema::table('stock_fca', function (Blueprint $table) {
            $table->string('vehicle_type')->nullable();
            $table->integer('uploader_id')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('stock_peugeot_citroen_ds', function (Blueprint $table) {
            $table->dropColumn('vehicle_type');
            $table->dropColumn('uploader_id');
        });

        Schema::table('stock_retail_central_europe', function (Blueprint $table) {
            $table->dropColumn('uploader_id');
        });

        Schema::table('stock_mercedes', function (Blueprint $table) {
            $table->dropColumn('vehicle_type');
            $table->dropColumn('uploader_id');
        });

        Schema::table('stock_opel', function (Blueprint $table) {
            $table->dropColumn('vehicle_type');
            $table->dropColumn('uploader_id');
        });

        Schema::table('stock_fca', function (Blueprint $table) {
            $table->dropColumn('vehicle_type');
            $table->dropColumn('uploader_id');
        });
    }
}
