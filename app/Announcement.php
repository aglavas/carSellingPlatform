<?php

namespace App;

use App\Mail\AnnouncementCreated;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Mail;

class Announcement extends Model
{
    protected $dates = [
        'published_at'
    ];

    protected $casts = [
        'notify_used_cars_users' => 'boolean',
        'notify_new_cars_users' => 'boolean'
    ];

    protected static function booted()
    {
        static::created(function ($announcement) {
            if ($announcement->notify_used_cars_users || $announcement->notify_new_cars_users) {
                Mail::to(
                   'noreply@emilfrey.carmarket.io'
                )
                    ->bcc(
                       User::select('email')
                        ->when($announcement->notify_used_cars_users, function ($query) {
                            return $query->orWhere('stock_type', 'UC');
                        })
                        ->when($announcement->notify_new_cars_users, function ($query) {
                            return $query->orWhere('stock_type', 'NC');
                        })
                        ->get()
                        ->pluck('email'))
                    ->send(new AnnouncementCreated($announcement->toArray()));
            }
        });
    }
}
