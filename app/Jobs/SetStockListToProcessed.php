<?php

namespace App\Jobs;

use App\StockListUpload;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;

class SetStockListToProcessed implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    protected $stockList;

    /**
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct($stockList)
    {
        $this->stockList = $stockList;
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
        $this->stockList->update([
            'status' => '✔'
        ]);
    }
}
