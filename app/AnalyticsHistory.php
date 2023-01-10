<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class AnalyticsHistory extends Model
{
    /**
     * @var array
     */
    protected $fillable = [
        'stats'
    ];

    protected $casts = [
      'stats' => 'json'
    ];

    /**
     * @var string
     */
    protected $table = 'analytics_history';
}
