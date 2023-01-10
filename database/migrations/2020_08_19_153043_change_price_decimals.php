<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class ChangePriceDecimals extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('stock_retail_central_europe', function (Blueprint $table) {
            $table->decimal('b2b_price_ex_vat', 14)->change();
            $table->decimal('price_in_euro', 14)->change();
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
            $table->decimal('b2b_price_ex_vat', 8)->change();
            $table->decimal('price_in_euro', 8)->change();
        });
    }
}
