<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Notification extends Model
{
    const UPLOAD_NEW_VIN = 'upload_new_vin';
    const UPDATE_EXISTING_VIN = 'update_existing_vin';

    /**
     * @var string
     */
    protected $table = 'notifications';

    /**
     * @var array
     */
    protected $fillable = [
        'event_type',
        'list_type',
        'company',
        'country',
        'user_id',
        'data_count',
        'meta_data'
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array
     */
    protected $casts = [
        'meta_data' => 'json',
    ];

    /**
     * Notification user shown mapping
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsToMany
     */
    public function users()
    {
        return $this->belongsToMany(User::class, 'user_notification_pivot', 'notification_id','user_id');
    }
}
