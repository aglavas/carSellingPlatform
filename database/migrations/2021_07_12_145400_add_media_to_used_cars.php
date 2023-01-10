<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddMediaToUsedCars extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('stock_retail_central_europe', function (Blueprint $table) {
            $table->text('media_path')->nullable();
            $table->text('color_description')->change();
            $table->text('note')->change();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('stock_retail_central_europe', function (Blueprint $table) {
            $table->dropColumn('media_path');
            $table->string('color_description')->change();
            $table->string('note')->change();
        });
    }
}
