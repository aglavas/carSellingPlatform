<?php

namespace App\Http\Controllers\Livewire\Filters;

use Livewire\Component;

class TransactionStatusCheckboxFilter extends Component
{
    /**
     * @var array
     */
    public $options = [];

    /**
     * @var string
     */
    public $status;

    /**
     * @var array
     */
    protected $listeners = ['refreshTransactionStatus'];

    /**
     * Mount the component
     */
    public function mount()
    {
        $this->status = request()->input('transaction_status', 'all');

        $this->options = [
            'all' => 'All entries',
            'in_progress' => 'In progress',
            'in_cart' => 'In cart',
        ];
    }

    /**
     * Refresh transaction status
     *
     * @param $status
     */
    public function refreshTransactionStatus($status)
    {
        if (!$status) {
            $this->status = 'all';
        }

        $this->status = $status;

        $this->render();
    }

    /**
     * Apply selection
     *
     * @param $key
     */
    public function apply($key)
    {
        $this->status = $key;

        $this->emit('filterToggled', ['column' => 'transaction_status', 'values' => $this->status]);
    }

    /**
     * Render the component
     *
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View
     */
    public function render()
    {
        return view('frontend.livewire.filters.transaction-status-checkbox-filter');
    }
}
