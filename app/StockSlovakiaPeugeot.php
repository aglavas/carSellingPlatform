<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class StockSlovakiaPeugeot extends Model
{
    /**
     * @var string
     */
    protected $table = 'stock_sk_p';

    /**
     * @var array
     */
    protected $guarded = ['id'];
}
