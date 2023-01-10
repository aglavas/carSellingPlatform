<?php

namespace App\Http\Controllers\Livewire\Filters;

use App\Transaction;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Support\Facades\Auth;
use App\Traits\WithFilterableOptions;
use Livewire\Component;

class SelectFilter extends Component
{
    use WithFilterableOptions;

    /**
     * @var
     */
    public $column, $label, $columnAs, $labelBy;

    /**
     * @var
     */
    public $resource;

    /**
     * @var
     */
    public $values;

    /**
     * @var array
     */
    public $options = [];

    /**
     * @var array
     */
    public $fixedOptions = [];

    /**
     * @var array
     */
    public $selected = [];

    /**
     * @var array
     */
    protected $listeners = ['refreshFilter', 'initializeFilters'];

    /**
     * @var string
     */
    public $transactionType;

    /**
     * @var string
     */
    public $listType;

    /**
     * Render the component
     *
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View
     */
    public function render()
    {
        return view('frontend.livewire.filters.select-filter');
    }

    /**
     * Mount the component
     *
     * @param string $resourceClass
     */
    public function mount(string $resourceClass)
    {
        $this->resource = new $resourceClass;
        $this->selected = [];

        if ($this->columnAs) {
            $query = $this->resource->select($this->column.' as '.$this->columnAs);

            $query = $this->authorizationFilter($query);

            $optionArray = $query->groupBy($this->columnAs)->get()->pluck(
                $this->columnAs,
                $this->columnAs
            )->sort()->filter()->toArray();
        } else {
            if ($this->column === 'firstregistration') {
                $query = $this->resource->select($this->column)->groupBy($this->column)->get();

                $registrationCollection = $query->pluck('firstregistration',
                    'firstregistration')->sort()->filter()->toArray();

                $optionArray = [];

                foreach ($registrationCollection as $key => $registrationDate) {
                    $registrationYear = $registrationDate->format('Y');
                    $optionArray[$registrationYear] = $registrationYear;
                }

                rsort($optionArray);
            } else {
                $query = $this->resource->select($this->column);

                $query = $this->authorizationFilter($query);

                $optionArray = $query->groupBy($this->column)->get()->pluck(
                    $this->column,
                    $this->column
                )->sort()->filter()->toArray();
            }
        }

        $this->options = $this->formatOptions((count($this->fixedOptions) > 0)? $this->fixedOptions : $optionArray);
    }

    /**
     * Update selected
     *
     * @param $value
     */
    public function updatedSelected($value)
    {
        $this->emit('filterToggled', ['column' => $this->column, 'values' => array_values($this->selected)]);
    }

    /**
     * Refresh filter
     *
     * @param $filters
     * @param  bool  $reset
     */
    public function refreshFilter($filters, $reset = false)
    {
        if ($this->columnAs) {
            $query = $this->resource->select($this->column.' as '.$this->columnAs);

            $query = $this->authorizationFilter($query);

            $options = $query->groupBy($this->columnAs);
        } else {
            $query = $this->resource->select($this->column);

            $query = $this->authorizationFilter($query);

            $options = $query->groupBy($this->column);
        }
        $options = $this->applyFilters($options, $filters, $this->column, $this->columnAs);

        if ($this->columnAs) {
            $optionArray = $options->get()->pluck($this->columnAs, $this->columnAs)->sort()->filter()->toArray();
        } else {
            if ($this->column === 'firstregistration') {
                $firstRegistrationOptionArray = $options->get()->pluck($this->column, $this->column)->sort()->filter()->toArray();

                $optionArray = [];

                foreach ($firstRegistrationOptionArray as $key => $registrationDate) {
                    $registrationYear = $registrationDate->format('Y');
                    $optionArray[$registrationYear] = $registrationYear;
                }

                rsort($optionArray);
            } else {
                $optionArray = $options->get()->pluck($this->column, $this->column)->sort()->filter()->toArray();
            }
        }
        $this->options = $this->formatOptions((count($this->fixedOptions) > 0)? $this->fixedOptions : $optionArray);

        if ($reset) {
            $this->selected = [];
        }
    }

    /**
     * Format select options
     *
     * @param  array  $optionArray
     * @return array
     */
    protected function formatOptions(array $optionArray)
    {
        $finalOptionArray = [];

        // Cannot reference key in foreach. No better way!
        foreach ($optionArray as $key => $value) {
            $value = str_replace("'", '', $value);
            $finalOptionArray[$this->column.'_'.$key] = $value;
        }

        return $finalOptionArray;
    }

    /**
     * Get selected array property
     *
     * @return array
     */
    public function getSelectedArrayProperty()
    {
        return $this->selected;
    }

    /**
     * Get filter container height
     *
     * @param array $options
     * @return string
     */
    public function getHeight(array $options)
    {
        if (count($options) >= 7) {
            return "overflow-y-scroll h-72";
        }

        return "h-full";
    }

    /**
     * Initialize selected values into filter
     *
     * @param $filters
     */
    public function initializeFilters($filters)
    {
        $columnFilter = $filters[$this->column];

        $this->selected = $columnFilter['values'];

        $this->refreshFilter($filters);
    }

    /**
     * Add authorization filter for select queries (transactions)
     *
     * @param Builder $query
     * @return Builder
     */
    private function authorizationFilter(Builder $query)
    {
        if ($this->resource instanceof Transaction) {
            if ($this->listType === 'admin') {
                return $query;
            }

            $user = Auth::user();

            if (($user->isBuyer() && $user->isSeller()) || $user->isAdmin()) {
                if ($this->transactionType == 'seller') {
                    $query->where('seller_company_id', $user->company->id)->where('country', $user->country);
                } else {
                    $query->where('buyer_id', $user->id);
                }
            } else if ($user->isSeller()) {
                $query->where('seller_company_id', $user->company->id)->where('country', $user->country);
            } else if ($user->isBuyer()) {
                $query->where('buyer_id', $user->id);
            }

            if ($this->listType === 'enquiry') {
                $query->whereIn('status', [Transaction::TRANSACTION_STATUS_DENIED, Transaction::TRANSACTION_STATUS_IN_PROGRESS, Transaction::TRANSACTION_STATUS_VEHICLE_REMOVED_DURING_TRANSACTION]);
            } elseif ($this->listType === 'order') {
                $query->where('status', '=', Transaction::TRANSACTION_STATUS_APPROVED);
            }

        }

        return $query;
    }
}
