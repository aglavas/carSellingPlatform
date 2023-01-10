<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddNotifyUsedAndNewCarUserToAnnouncementsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('announcements', function (Blueprint $table) {
            $table->dropColumn('notify_users');
            $table->boolean('notify_used_cars_users')->nullable();
            $table->boolean('notify_new_cars_users')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('announcements', function (Blueprint $table) {
            $table->boolean('notify_users');
            $table->dropColumn(['notify_used_cars_users', 'notify_new_cars_users']);
        });
    }
}
