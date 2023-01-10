<?php

namespace App\Http\Controllers\Livewire;

use App\Transaction;
use Illuminate\Database\Eloquent\Model;
use Livewire\Component;

class TransactionSearchFilter extends Component
{
    /**
     * @var
     */
    public $filters, $resetUrl;

    /**
     * @var Model
     */
    public $resource;

    /**
     * @var String
     */
    public $resourceClass;

    /**
     * @var string
     */
    public $selectedFilter;

    /**
     * @var string
     */
    public $transactionType;

    /**
     * @var string
     */
    public $listType;

    /**
     * Mount the component
     *
     * @param Model $resource
     * @param array $filters
     * @param $selectedFilter
     * @param $transactionType
     * @param $listType
     */
    public function mount(Model $resource, array $filters, $selectedFilter, $transactionType, $listType)
    {
        $this->resource = $resource;

        $this->resourceClass = Transaction::class;

        $this->filters = $filters;

        $this->selectedFilter = $selectedFilter;

        $this->resetUrl = url()->current();

        $this->transactionType = $transactionType;

        $this->listType = $listType;
    }

    /**
     * Render the component
     *
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View
     */
    public function render()
    {
        return view('frontend.livewire.transaction-search-filter');
    }
}
