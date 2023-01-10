<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateStockOpelTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('stock_opel', function (Blueprint $table) {
            $table->id();
            $table->string('country', 2)->nullable();
            $table->string('brand')->index()->nullable();
            $table->string('family')->index()->nullable();
            $table->string('model_name')->index()->nullable();
            $table->string('version')->index()->nullable();
            $table->string('interior')->index()->nullable();
            $table->string('color')->index()->nullable();
            $table->string('vpvu')->index()->nullable();
            $table->string('caf')->index()->nullable();
            $table->string('order_number')->index()->nullable();
            $table->string('vin')->index()->nullable();
            $table->text('options')->index()->nullable();
            $table->integer('co2')->index()->nullable();
            $table->date('transaction_date')->index()->nullable();
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
        Schema::dropIfExists('stock_opel');
    }
}
