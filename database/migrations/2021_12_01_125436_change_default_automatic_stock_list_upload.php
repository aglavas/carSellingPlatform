<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class ChangeDefaultAutomaticStockListUpload extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('stock_list_uploads', function (Blueprint $table) {
            $table->boolean('automatic')->default(true)->change();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('stock_list_uploads', function (Blueprint $table) {
            $table->boolean('automatic')->default(false)->change();
        });
    }
}
