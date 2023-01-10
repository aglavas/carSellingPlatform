<?php

namespace App\Http\Controllers\Livewire\Analytics;

use App\Traits\AnalyticsFiltering;
use App\Transaction;
use Livewire\Component;
use App\Traits\ColorPalette;
use Illuminate\Support\Facades\DB;

class TransactionByTime extends Component
{
    use ColorPalette, AnalyticsFiltering;

    /**
     * @var array
     */
    public $time;

    /**
     * @var array
     */
    public $values;

    /**
     * @var integer
     */
    public $rand;

    /**
     * @var array
     */
    public $color = [];

    /**
     * Render the component
     *
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View
     */
    public function render()
    {
        $this->setValues();

        return view('frontend.livewire.analytics.transaction-by-time');
    }

    /**
     * Set values
     */
    protected function setValues()
    {
        list($transactionMin, $transactionMax) = $this->filterResourceByPeriod(Transaction::class);

        if ((!$transactionMin) || (!$transactionMax)) {
            $resultCollection = collect([]);
        } else {
            $resultObject =
                DB::select("
            SELECT date_trunc('day', dd):: date AS day,
            (SELECT COUNT(*) FROM transactions
            WHERE date(created_at) <= date_trunc('day', dd)) AS \"count\"
            FROM generate_series 
            ( '$transactionMin'::timestamp
            , '$transactionMax'::timestamp
            , '1 day'::interval) dd
        ");
            $resultArray = array_map(function ($value) {
                return (array)$value;
            }, $resultObject);

            $resultCollection = collect($resultArray);
        }

        $this->time = $resultCollection->pluck('day')->toArray();
        $this->values = $resultCollection->pluck('count')->toArray();

        $this->color = $this->getColorArray(1);

        $this->rand = rand(11111, 99999999);
    }
}
