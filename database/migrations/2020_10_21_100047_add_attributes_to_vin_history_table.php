<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddAttributesToVinHistoryTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('vin_history', function (Blueprint $table) {
            $table->json('attributes')->nullable();
            $table->text('hashed_attributes')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('vin_history', function (Blueprint $table) {
            $table->dropColumn('attributes');
            $table->dropColumn('hashed_attributes');
        });
    }
}
