<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddAdditionalDataToFrontendNotificationTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('frontend_notification', function (Blueprint $table) {
            $table->string('user_type')->nullable();
            $table->string('country')->nullable();
            $table->integer('company_id')->nullable()->unsigned();
            $table->foreign('company_id')->references('id')->on('companies')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('frontend_notification', function (Blueprint $table) {
            $table->dropColumn('user_type');
            $table->dropColumn('country');
            $table->dropColumn('company_id');
        });
    }
}
