<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateNotificationsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('notifications', function (Blueprint $table) {
            $table->id();
            $table->string('event_type');
            $table->string('list_type')->nullable();
            $table->string('country')->nullable();
            $table->string('company')->nullable();
            $table->integer('user_id')->unsigned();
            $table->foreign('user_id','user_id_foreign')->references('id')->on('users')->onDelete('set null');
            $table->integer('data_count')->nullable();
            $table->text('meta_data')->nullable();
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
        Schema::dropIfExists('notifications');
    }
}
