<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddOptionCodeDescriptionEnglishToStockRetailCentralEuropeTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('stock_retail_central_europe', function (Blueprint $table) {
            $table->text('option_code_description_english')->nullable();
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
            $table->dropColumn('option_code_description_english');
        });
    }
}
