<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddEnquiryStatusToCarTables extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('stock_retail_central_europe', function (Blueprint $table) {
            $table->string('enquiry_status')->nullable();
        });

        Schema::table('stock_cz_psa', function (Blueprint $table) {
            $table->string('enquiry_status')->nullable();
        });

        Schema::table('stock_fca', function (Blueprint $table) {
            $table->string('enquiry_status')->nullable();
        });

        Schema::table('stock_hr_mb', function (Blueprint $table) {
            $table->string('enquiry_status')->nullable();
        });

        Schema::table('stock_hr_mb_vans', function (Blueprint $table) {
            $table->string('enquiry_status')->nullable();
        });

        Schema::table('stock_hr_psa', function (Blueprint $table) {
            $table->string('enquiry_status')->nullable();
        });

        Schema::table('stock_mercedes', function (Blueprint $table) {
            $table->string('enquiry_status')->nullable();
        });

        Schema::table('stock_opel', function (Blueprint $table) {
            $table->string('enquiry_status')->nullable();
        });

        Schema::table('stock_peugeot_citroen_ds', function (Blueprint $table) {
            $table->string('enquiry_status')->nullable();
        });

        Schema::table('stock_retail', function (Blueprint $table) {
            $table->string('enquiry_status')->nullable();
        });

        Schema::table('stock_si_c', function (Blueprint $table) {
            $table->string('enquiry_status')->nullable();
        });

        Schema::table('stock_si_p', function (Blueprint $table) {
            $table->string('enquiry_status')->nullable();
        });

        Schema::table('stock_sk_c', function (Blueprint $table) {
            $table->string('enquiry_status')->nullable();
        });

        Schema::table('stock_sk_opel', function (Blueprint $table) {
            $table->string('enquiry_status')->nullable();
        });

        Schema::table('stock_sk_p', function (Blueprint $table) {
            $table->string('enquiry_status')->nullable();
        });

        Schema::table('stock_switzerland', function (Blueprint $table) {
            $table->string('enquiry_status')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('stock_retail_central_europe', function (Blueprint $table) {
            $table->dropColumn('enquiry_status');
        });

        Schema::table('stock_cz_psa', function (Blueprint $table) {
            $table->dropColumn('enquiry_status');
        });

        Schema::table('stock_fca', function (Blueprint $table) {
            $table->dropColumn('enquiry_status');
        });

        Schema::table('stock_hr_mb', function (Blueprint $table) {
            $table->dropColumn('enquiry_status');
        });

        Schema::table('stock_hr_mb_vans', function (Blueprint $table) {
            $table->dropColumn('enquiry_status');
        });

        Schema::table('stock_hr_psa', function (Blueprint $table) {
            $table->dropColumn('enquiry_status');
        });

        Schema::table('stock_mercedes', function (Blueprint $table) {
            $table->dropColumn('enquiry_status');
        });

        Schema::table('stock_opel', function (Blueprint $table) {
            $table->dropColumn('enquiry_status');
        });

        Schema::table('stock_peugeot_citroen_ds', function (Blueprint $table) {
            $table->dropColumn('enquiry_status');
        });

        Schema::table('stock_retail', function (Blueprint $table) {
            $table->dropColumn('enquiry_status');
        });

        Schema::table('stock_si_c', function (Blueprint $table) {
            $table->dropColumn('enquiry_status');
        });

        Schema::table('stock_si_p', function (Blueprint $table) {
            $table->dropColumn('enquiry_status');
        });

        Schema::table('stock_sk_c', function (Blueprint $table) {
            $table->dropColumn('enquiry_status');
        });

        Schema::table('stock_sk_opel', function (Blueprint $table) {
            $table->dropColumn('enquiry_status');
        });

        Schema::table('stock_sk_p', function (Blueprint $table) {
            $table->dropColumn('enquiry_status');
        });

        Schema::table('stock_switzerland', function (Blueprint $table) {
            $table->dropColumn('enquiry_status');
        });
    }
}
