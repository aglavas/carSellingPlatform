<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddAdditionalDataFieldsToUsersAndCompanyTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('users', function (Blueprint $table) {
            $table->string('stock_type')->nullable();
            $table->string('import_types')->nullable();
            $table->text('comment')->nullable();
        });

        Schema::table('companies', function (Blueprint $table) {
            $table->text('address')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('users', function (Blueprint $table) {
            $table->dropColumn(['stock_type', 'import_types', 'comment']);
        });
        Schema::table('companies', function (Blueprint $table) {
            $table->dropColumn(['address']);
        });
    }
}
