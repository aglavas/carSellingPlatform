<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddPriceInEuroToStockRetailCentralEuropeTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('stock_retail_central_europe', function (Blueprint $table) {
            $table->decimal('price_in_euro')->nullable();
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
            $table->dropColumn('price_in_euro');
        });
    }
}
