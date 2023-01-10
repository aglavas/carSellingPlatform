<?php

namespace App\Http\Controllers\Livewire\Analytics;

use App\ActivityLog;
use App\StockListUpload;
use App\StockVehicleUsed;
use App\StockVehicleNew;
use App\Traits\AnalyticsFiltering;
use App\Transaction;
use Livewire\Component;

class Scorecards extends Component
{
    use AnalyticsFiltering;

    /**
     * @var int
     */
    public $downloads = 0;

    /**
     * @var int
     */
    public $newCars = 0;

    /**
     * @var int
     */
    public $usedCars = 0;

    /**
     * @var int
     */
    public $uploads = 0;

    /**
     * @var int
     */
    public $transactions = 0;

    /**
     * Render the component
     *
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View
     */
    public function render()
    {
        $this->setValues();
        return view('frontend.livewire.analytics.scorecards');
    }

    /**
     * Set values
     */
    protected function setValues()
    {
        $stockListUpload = StockListUpload::query();
        $transaction = Transaction::query();
        $usedCars = StockVehicleUsed::query();
        $newCars = StockVehicleNew::query();
        $download = ActivityLog::downloads();

        $this->uploads = $this->filterByPeriod($stockListUpload)->count();
        $this->transactions = $this->filterByPeriod($transaction)->count();
        $this->downloads = $this->filterByPeriod($download)->count();
        $this->usedCars = $this->filterByPeriod($usedCars)->count();
        $this->newCars = $this->filterByPeriod($newCars)->count();
    }
}
