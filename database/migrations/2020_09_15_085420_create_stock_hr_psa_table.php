<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateStockHrPsaTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('stock_hr_psa', function (Blueprint $table) {
            $table->id();
            $table->string('caf')->index()->nullable();
            $table->string('user')->index()->nullable();
            $table->string('origin_caf')->index()->nullable();
            $table->string('version')->index()->nullable();
            $table->string('family')->index()->nullable();
            $table->string('exterior_fitting')->index()->nullable();
            $table->string('interior_trim')->index()->nullable();
            $table->text('options')->index()->nullable();
            $table->string('management_attributes')->index()->nullable();
            $table->string('counter_mark')->index()->nullable();
            $table->string('destination')->index()->nullable();
            $table->string('forced_destination')->index()->nullable();
            $table->string('blocked_oe')->index()->nullable();
            $table->string('flow_type')->index()->nullable();
            $table->string('reserve_reason')->index()->nullable();
            $table->string('vis_iso_year_code')->index()->nullable();
            $table->string('locale_reference')->index()->nullable();
            $table->string('time_lagged_oe')->index()->nullable();
            $table->date('transmission_date_icppf')->index()->nullable();
            $table->string('observation')->index()->nullable();
            $table->string('caf_type')->index()->nullable();
            $table->string('charging_month')->index()->nullable();
            $table->string('statute_caf')->index()->nullable();
            $table->string('vn_psv')->index()->nullable();
            $table->string('vn_psv_label')->index()->nullable();
            $table->string('order_number')->index()->nullable();
            $table->string('external_number')->index()->nullable();
            $table->string('vin')->index()->unique();
            $table->date('ecom_prev')->index()->nullable();
            $table->date('ecom_real')->index()->nullable();
            $table->date('mad_prev')->index()->nullable();
            $table->date('mad_real')->index()->nullable();
            $table->date('creation_date')->index()->nullable();
            $table->date('modification_date')->index()->nullable();
            $table->date('division_date')->index()->nullable();
            $table->string('engagement_line')->index()->nullable();
            $table->string('country', 2)->index()->nullable();
            $table->string('car_body_code')->index()->nullable();
            $table->date('cancellation_date')->index()->nullable();
            $table->string('foreclosure_sale')->index()->nullable();
            $table->string('sale')->index()->nullable();
            $table->date('eusi_date')->index()->nullable();
            $table->date('smon_date')->index()->nullable();
            $table->date('ecom_date')->index()->nullable();
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
        Schema::dropIfExists('stock_hr_psa');
    }
}
