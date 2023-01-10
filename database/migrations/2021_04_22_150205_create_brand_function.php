<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

class CreateBrandFunction extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        DB::beginTransaction();

        DB::unprepared(<<<'SQL'
            CREATE OR REPLACE FUNCTION public.brand(brandid integer default null)
            RETURNS varchar
            LANGUAGE sql
            STABLE
            AS $function$
                SELECT name FROM brands WHERE id = brandid;
            $function$
            ;
        SQL);

        DB::commit();
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {

    }
}
