<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class VinHistory extends Model
{
    const EVENT_TYPE_ADDED = 'added';
    const EVENT_TYPE_DELETED = 'deleted';

    /**
     * @var string
     */
    protected $table = 'vin_history';

    /**
     * @var array
     */
    protected $fillable = ['vin', 'event_type', 'company', 'country', 'user_id', 'created_at', 'attributes'];
}
