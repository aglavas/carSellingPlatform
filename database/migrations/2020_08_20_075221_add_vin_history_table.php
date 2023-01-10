<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddVinHistoryTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('vin_history', function (Blueprint $table) {
            $table->id();
            $table->string('vin')->index();
            $table->string('event_type');
            $table->string('company')->nullable();
            $table->string('country')->nullable();
            $table->integer('user_id')->unsigned();
            $table->foreign('user_id','user_id_foreign')->references('id')->on('users')->onDelete('set null');
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
        Schema::dropIfExists('vin_history');
    }
}
