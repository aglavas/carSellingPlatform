<?php

namespace App;

use App\Mail\NewCarListUploaded;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Mail;

class NewCarListUpload extends Model
{
    protected $guarded = ['id'];

    protected static function booted()
    {
        static::created(function ($newCarListUpload) {
            $newCarListUpload->update([
                'status' => 'processing',
                'uploader_id' => auth()->user()->id
            ]);
            Mail::to([
                'kim.pattynama@emilfrey.ch',
                'marin.maric@freyservices.hr',
                'tatjana.sitar@freyservices.hr'
            ])
                ->send(new NewCarListUploaded([
                        'list_data' => $newCarListUpload->toArray()
                    ])
                );
        });
    }

    public function uploader()
    {
        return $this->belongsTo(User::class);
    }
}
