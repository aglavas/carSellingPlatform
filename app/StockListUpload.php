<?php

namespace App;

use App\Imports\StockUsedCentralEuropeImport;
use App\Jobs\ImportJob;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Auth;

class StockListUpload extends Model
{
    protected $guarded = ['id'];

    protected static function booted()
    {
        static::created(function ($stockList) {
            $stockList->update([
                'status' => 'processing',
                'uploader_id' => $stockList->uploader_id ?? auth()->user()->id
            ]);
            ImportJob::dispatchSync($stockList->file_path, $stockList->list_type, $stockList);
        });
    }

    /**
     * List belongs to uploader
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function uploader()
    {
        return $this->belongsTo(User::class);
    }

    /**
     * Get only current user uploads
     *
     * @param $query
     * @return mixed
     */
    public function scopeOfUser($query)
    {
        return $query->where('uploader_id', Auth::user()->id);
    }

    /**
     * Upload morphs to one log
     */
    public function log()
    {
        return $this->morphOne(ActivityLog::class, 'subject');
    }
}
