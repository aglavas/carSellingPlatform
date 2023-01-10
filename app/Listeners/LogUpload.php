<?php

namespace App\Listeners;

use App\Events\ImportFinished;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;

class LogUpload
{
    /**
     * Create the event listener.
     *
     * @return void
     */
    public function __construct()
    {
        //
    }

    /**
     * @param ImportFinished $importFinished
     */
    public function handle(ImportFinished $importFinished)
    {
        $model = $importFinished->stockListUpload;

        $user = $importFinished->user;

        $vinArray = $importFinished->vinArray;

        $rowCount = [
            'row_count' => count($vinArray)
        ];

        activity('import_success')
            ->performedOn($model)
            ->causedBy($user)
            ->withProperties($rowCount)->log('Import success.');
    }
}
