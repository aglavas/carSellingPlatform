<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class StockSlovakiaOpel extends Model
{
    /**
     * @var string
     */
    protected $table = 'stock_sk_opel';

    /**
     * @var array
     */
    protected $guarded = ['id'];
}
