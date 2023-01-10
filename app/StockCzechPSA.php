<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class StockCzechPSA extends Model
{
    /**
     * @var string
     */
    protected $table = 'stock_cz_psa';

    /**
     * @var array
     */
    protected $guarded = ['id'];
}
