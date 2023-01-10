<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class StockSwitzerland extends Model
{

    protected $table = 'stock_switzerland';

    protected $guarded = ['id'];

    protected $casts = [
        'duty_paid' => 'boolean'
    ];

    protected $dates = ['key_date', 'customs_on', 'shipped_on', 'port_on', 'train_on', 'pdi_on', 'carrier_on'];
}
