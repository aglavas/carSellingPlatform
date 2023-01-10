<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class StockSloveniaPeugeot extends Model
{
    /**
     * @var string
     */
    protected $table = 'stock_si_p';

    /**
     * @var array
     */
    protected $guarded = ['id'];
}
