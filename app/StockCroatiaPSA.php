<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class StockCroatiaPSA extends Model
{
    /**
     * @var string
     */
    protected $table = 'stock_hr_psa';

    /**
     * @var array
     */
    protected $guarded = ['id'];
}
