<?php

namespace App\Http\Controllers\Livewire;

use Livewire\Component;

class SortBulkAction extends Component
{

    /**
     * Sort field
     *
     * @var null
     */
    public $sortField;

    /**
     * Sort direction
     *
     * @var string
     */
    public $sortDirection;

    /**
     * Transaction flag
     *
     * @var bool
     */
    public $transaction = false;

    /**
     * Mount the component
     *
     * @param string $sortField
     * @param string $sortDirection
     * @param bool $transaction
     */
    public function mount($sortField = 'created_at', $sortDirection = 'desc', $transaction = false)
    {
        $this->sortField = $sortField;
        $this->sortDirection = $sortDirection;
        $this->transaction = $transaction;
    }

    /**
     * Render the component
     *
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View
     */
    public function render()
    {
        return view('frontend.livewire.sort-bulk-action');
    }

    /**
     * Sort by
     *
     * @param $field
     */
    public function sortBy($field)
    {
        $fieldArray = explode('-', $field);

        if ($this->transaction) {
            if ($fieldArray[0] === 'created') {
                $this->sortField = 'created_at';
            }
        } else {
            if ($fieldArray[0] === 'price') {
                $this->sortField = 'b2b_price_ex_vat';
            } elseif ($fieldArray[0] === 'created') {
                $this->sortField = 'created_at';
            }  elseif ($fieldArray[0] === 'brand') {
                $this->sortField = 'brand';
            }  elseif ($fieldArray[0] === 'company') {
                $this->sortField = 'company';
            }
        }

        $this->sortDirection = $fieldArray[1];

        $this->emit('refreshSort', ['sortField' => $this->sortField, 'sortDirection' => $this->sortDirection]);
    }
}
