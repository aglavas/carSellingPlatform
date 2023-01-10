<?php

namespace App\Http\Controllers\Livewire\Analytics;

use App\Traits\AnalyticsFiltering;
use App\Transaction;
use Livewire\Component;
use App\Traits\ColorPalette;
use Illuminate\Support\Facades\DB;

class TransactionByCompany extends Component
{
    use ColorPalette, AnalyticsFiltering;

    /**
     * @var array
     */
    public $companies;

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

        return view('frontend.livewire.analytics.transaction-by-company');
    }

    /**
     * Set values
     */
    protected function setValues()
    {
        $transaction = new Transaction();

        $query = $transaction->with('company')->select('seller_company_id', DB::raw('count(*) as total'));

        $query = $this->filterByPeriod($query);

        $transactionCollection = $query->groupBy('seller_company_id')->get();

        $companyArray = $transactionCollection->pluck('company.name')->toArray();

        $valueArray = $transactionCollection->pluck('total')->toArray();

        $this->color = $this->getColorArray(count($companyArray));

        $this->companies = $companyArray;

        $this->values = $valueArray;

        $this->rand = rand(11111, 99999999);
    }
}
