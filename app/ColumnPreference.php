<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class ColumnPreference extends Model
{
    /**
     * @var string
     */
    protected $table = 'column_preference';

    /**
     * @var array
     */
    protected $fillable = [
        'vehicle_type',
        'columns',
        'user_id',
    ];

    /**
     * @var array
     */
    protected $casts = [
        'columns' => 'json'
    ];
}
