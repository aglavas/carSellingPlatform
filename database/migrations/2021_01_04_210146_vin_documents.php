<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class VinDocuments extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('vin_documents', function (Blueprint $table) {
            $table->id();
            $table->string('vin');
            $table->string('path1');
            $table->text('description1')->nullable();
            $table->string('path2')->nullable();
            $table->text('description2')->nullable();
            $table->string('path3')->nullable();
            $table->text('description3')->nullable();
            $table->string('path4')->nullable();
            $table->text('description4')->nullable();
            $table->string('path5')->nullable();
            $table->text('description5')->nullable();
            $table->string('path6')->nullable();
            $table->text('description6')->nullable();
            $table->string('path7')->nullable();
            $table->text('description7')->nullable();
            $table->string('path8')->nullable();
            $table->text('description8')->nullable();
            $table->string('path9')->nullable();
            $table->text('description9')->nullable();
            $table->string('path10')->nullable();
            $table->text('description10')->nullable();
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
        Schema::dropIfExists('vin_documents');
    }
}
