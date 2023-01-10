<?php

namespace App\Http\Controllers\Livewire;

use App\Resolvers\LabelBy\TransactionStatus;
use App\Resolvers\LabelBy\TransactionCountry;
use App\Resolvers\LabelBy\Company;
use App\Transaction;
use Livewire\Component;

class TransactionSearch extends Component
{
    /**
     * @var Transaction
     */
    public $resource;

    /**
     * @var array
     */
    public $transactions;

    /**
     * @var string
     */
    public $type;

    /**
     * @var string
     */
    public $listType;

    /**
     * @var array
     */
    public $enquiry_id;

    /**
     * @var array
     */
    public $country;

    /**
     * @var array
     */
    public $status;

    /**
     * @var string
     */
    public $selectedFilter = null;

    public $statusOptions = [];

    /**
     * @var array
     */
    public $buyer_id;

    /**
     * @var string
     */
    public $vehicle_type;

    /**
     * @var array
     */
    public $filters;

    /**
     * Load the rest from config
     *
     * @var array
     */
    protected $queryString = [
        'enquiry_id',
        'country',
        'status',
        'buyer_id',
        'vehicle_type',
    ];

    protected $listeners = ['filterToggled'];

    /**
     * @param array $transactions
     * @param string $type
     * @param string $listType
     */
    public function mount(array $transactions, string $type, string $listType)
    {
        $this->resource = new Transaction();
        $this->transactions = $transactions;
        $this->type = $type;
        $this->listType = $listType;

        $this->filters = config('carmarket.frontend.transactions.filters')[$type];

        if ($this->listType === 'enquiries') {
            $this->statusOptions = [Transaction::TRANSACTION_STATUS_IN_PROGRESS, Transaction::TRANSACTION_STATUS_VEHICLE_REMOVED_DURING_TRANSACTION, Transaction::TRANSACTION_STATUS_DENIED];
        }

        if ($this->listType === 'orders') {
            $this->statusOptions = [Transaction::TRANSACTION_STATUS_APPROVED];
        }

        $this->getInitialFilters();
    }

    /**
     * Filter toggled listener
     *
     * @param $filter
     */
    public function filterToggled($filter)
    {
        $column = $filter['column'];
        $this->$column = $filter['values'];
        $this->filters[$filter['column']]['values'] = $filter['values'];

        $this->emit('refreshFilter', $this->filters);
    }

    /**
     * Get initial filters from config and structure accordingly
     *
     * @param $resource
     * @return mixed
     */
    public function getInitialFilters()
    {
        foreach ($this->filters as &$filter) {
            $column = $filter['column'];

            if (request()->input($column)) {
                $filter['values'] = request()->input($column);
                $this->$column = request()->input($column);
            }
        }
    }

    /**
     * Initialize filters
     */
    public function initializeFilters()
    {
        $this->emit('initializeFilters', $this->filters);
    }

    /**
     * Render the component
     *
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View
     */
    public function render()
    {
        return view('frontend.livewire.transaction-search');
    }
}
