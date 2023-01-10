<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateStockHrMbTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('stock_hr_mb', function (Blueprint $table) {
            $table->id();
            $table->string('imported_id')->index()->nullable();
            $table->string('order_number')->index()->nullable();
            $table->string('sun')->index()->nullable();
            $table->string('status')->index()->nullable();
            $table->date('allo_date')->index()->nullable();
            $table->string('bm_group')->index()->nullable();
            $table->string('nst')->index()->nullable();
            $table->string('cc')->index()->nullable();
            $table->string('paint_lower')->index()->nullable();
            $table->string('paint_upper')->index()->nullable();
            $table->string('upholstery')->index()->nullable();
            $table->text('configuration')->nullable();
            $table->string('customer_stock')->index()->nullable();
            $table->string('transaction_type')->index()->nullable();
            $table->string('bfs_number')->index()->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('stock_hr_mb');
    }
}
