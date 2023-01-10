<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateNewCarListUploadsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('new_car_list_uploads', function (Blueprint $table) {
            $table->id();
            $table->string('country')->nullable();
            $table->string('file_path');
            $table->string('status')->nullable();
            $table->string('list_type')->nullable();
            $table->string('uploader_id')->nullable();
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
        Schema::dropIfExists('new_car_list_uploads');
    }
}
