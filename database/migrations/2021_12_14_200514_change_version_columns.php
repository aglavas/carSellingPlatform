<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class ChangeVersionColumns extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('stock_vehicles', function (Blueprint $table) {
            $table->string('version_code')->nullable()->index();
            $table->renameColumn('version', 'version_description');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('stock_vehicles', function (Blueprint $table) {
            $table->dropColumn('version_code');
            $table->renameColumn('version_description', 'version');
        });
    }
}
