<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class StockSlovakiaCitroen extends Model
{
    /**
     * @var string
     */
    protected $table = 'stock_sk_c';

    /**
     * @var array
     */
    protected $guarded = ['id'];
}
