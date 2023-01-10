<?php

namespace App;

use Spatie\Activitylog\Models\Activity;

class ActivityLog extends Activity
{
    /**
     * Get the owning morphable model.
     */
    public function morphable()
    {
        return $this->morphTo();
    }

    /**
     * Scope used cars
     *
     * @param $query
     * @return mixed
     */
    public function scopeUsedCarsDownload($query)
    {
        return $query->where('log_name', 'export_success')->where('subject_type', StockUsedCentralEurope::class);
    }

    /**
     * Scope used cars
     *
     * @param $query
     * @return mixed
     */
    public function scopeDownloads($query)
    {
        return $query->where('log_name', 'export_success');
    }

    /**
     * Scope used cars
     *
     * @param $query
     * @return mixed
     */
    public function scopeNewCarsDownload($query)
    {
        return $query->where('log_name', 'export_success')->where('subject_type', '!=', StockUsedCentralEurope::class);
    }
}
