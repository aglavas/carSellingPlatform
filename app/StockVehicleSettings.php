<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class StockVehicleSettings extends Model
{
    /**
     * @var string
     */
    protected $table = 'vehicle_settings';

    /**
     * @var array
     */
    protected $guarded = ['id'];

    /**
     * @var bool
     */
    public $timestamps = false;
}
