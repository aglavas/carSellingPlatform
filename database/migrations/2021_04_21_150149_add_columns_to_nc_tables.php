<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddColumnsToNcTables extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('stock_fca', function (Blueprint $table) {
            $table->string('vpvu')->nullable();
        });

        Schema::table('stock_opel', function (Blueprint $table) {
            $table->string('company')->nullable();
        });

        Schema::table('stock_mercedes', function (Blueprint $table) {
            $table->string('vpvu')->nullable();
            $table->string('company')->nullable();
        });

        Schema::table('stock_peugeot_citroen_ds', function (Blueprint $table) {
            $table->string('vpvu')->nullable();
            $table->string('company')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('nc_tables', function (Blueprint $table) {
            $table->dropColumn('vpvu');
        });

        Schema::table('stock_opel', function (Blueprint $table) {
            $table->dropColumn('vpvu');
            $table->dropColumn('company');
        });

        Schema::table('stock_mercedes', function (Blueprint $table) {
            $table->dropColumn('vpvu');
            $table->dropColumn('company');
        });

        Schema::table('stock_peugeot_citroen_ds', function (Blueprint $table) {
            $table->dropColumn('vpvu');
            $table->dropColumn('company');
        });
    }
}
