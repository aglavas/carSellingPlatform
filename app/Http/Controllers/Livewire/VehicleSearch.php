<?php

namespace App\Http\Controllers\Livewire;

use App\Http\Controllers\Livewire\DataTable\WithPerPagePagination;
use App\StockVehicle;
use App\StockVehicleNew;
use App\Traits\WithFilterableOptions;
use Illuminate\Database\Eloquent\Model;
use Livewire\Component;
use Illuminate\Support\Facades\Auth;
use App\FilterSearch;

class VehicleSearch extends Component
{
    use WithPerPagePagination, WithFilterableOptions;

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
    public $sortDirection = 'asc';

    /**
     * @var Model
     */
    public $resource;

    /**
     * @var string
     */
    public $resourceClass;

    /**
     * @var
     */
    public $filters;

    /**
     * @var string
     */
    public $selectedFilter = null;

    /**
     * @var string
     */
    public $pageTitle;

    /**
     * @var array
     */
    protected $listeners = ['filterToggled', 'saveFilters', 'loadSelectedFilter'];

    /**
     * Load the rest from config
     *
     * @var array
     */
    protected $queryString = [
        'sortField',
        'sortDirection',
        'selectedFilter'
    ];

    /**
     * Mount the component
     */
    public function mount()
    {
        try {
            $this->resourceClass = config('carmarket.resource.all');
        } catch (\Exception $exception) {
            abort(404);
        }

        $this->resource = new $this->resourceClass;

        $this->filters = config("carmarket.frontend.filters");

        $filterKeyArray = array_keys($this->filters);

        $this->queryString = array_merge($this->queryString, $filterKeyArray);

        // Set properties initially to null
        foreach ($filterKeyArray as $filterKey) {
            $this->{$filterKey} = null;
        }

        //Get initial filters from config into filter property
        foreach ($this->getInitialFilters() as $filter) {
            $this->filters[$filter['column']] = $filter;
        }

        $urlParams = request()->input();

        foreach ($urlParams as $key => $value) {
            //todo Add check if exists
//            if ($this->{$key}) {
//                $this->{$key} = $value;
//            }
            $this->{$key} = $value;
        }

    }

    /**
     * Render template
     *
     * @return mixed
     */
    public function render()
    {
        session()->put('templateName', 'frontend.livewire.vehicle-search');
        return view('frontend.livewire.vehicle-search')->layout('frontend.layouts.app');
    }

    /**
     * Filter toggled listener
     *
     * @param $filter
     */
    public function filterToggled($filter)
    {
        $filterKeyArray = array_keys($this->filters);

        foreach ($filterKeyArray as $filterKey) {
            if (($this->filters[$filterKey]['type'] === 'single') && count($this->filters[$filterKey]['values'])) {
                $this->{$filterKey} = $this->filters[$filterKey]['values'];
            } else if (($this->filters[$filterKey]['type'] === 'max') && $this->filters[$filterKey]['values']) {
                $this->{$filterKey} = $this->filters[$filterKey]['values'];
            } else if (($this->filters[$filterKey]['type'] === 'custom') && $this->filters[$filterKey]['values']) {
                $this->{$filterKey} = $this->filters[$filterKey]['values'];
            } else {
                $this->{$filterKey} = null;
            }
        }

        $this->filters[$filter['column']]['values'] = $filter['values'];
        $this->{$filter['column']} = $filter['values'];

        $this->queryString = array_merge($this->queryString, $filterKeyArray);

        $this->emit('refreshResetFilters', $this->filters);
        $this->emit('refreshFilter', $this->filters);

        $transactionStatus = $this->filters['transaction_status']['values'];

        $this->emit('refreshTransactionStatus', $transactionStatus);
    }

    /**
     * Get initial filters from config and structure accordingly
     *
     * @return mixed
     */
    public function getInitialFilters()
    {
        return collect(config("carmarket.frontend.filters"))->map(function (
            $filter,
            $column
        ) {
            if (request()->input($column)) {
                return [
                    'column' => $filter['column'],
                    'values' => request()->input($column),
                    'type' => $filter['type']
                ];
            }

        })->filter()->toArray();
    }

    /**
     * Initialize filters
     */
    public function initializeFilters()
    {
        $this->emit('initializeFilters', $this->filters);
        $this->emit('refreshResetFilters', $this->filters);
    }

    /**
     * Load selected filter
     *
     * @param $selectedFilter
     * @return \Illuminate\Http\RedirectResponse
     */
    public function loadSelectedFilter($selectedFilter)
    {
        $filterSearch = FilterSearch::findOrFail($selectedFilter);

        $filters = $filterSearch->getFilters();

        if ($filters) {
            $this->selectedFilter = $selectedFilter;

            $loadedFilterArray = ['selectedFilter' => $selectedFilter];

            foreach ($filters as $key => $filter) {
                if ($filter['type'] === 'single' && count($filter['values'])) {
                    $loadedFilterArray[$key] = [];
                    foreach ($filter['values'] as $value) {
                        array_push($loadedFilterArray[$key], $value);
                    }
                } elseif ($filter['type'] === 'max' && $filter['values'] !== 0) {
                    $loadedFilterArray[$key] = $filter['values'];
                } elseif ($filter['type'] === 'custom' && $filter['values'] !== 0) {
                    $loadedFilterArray[$key] = $filter['values'];
                }
            }

            return redirect()->route('vehicle-search', $loadedFilterArray);
        }
    }

    /**
     * Save filters
     *
     * @param $name
     */
    public function saveFilters($name) {
        $user = Auth::user();

        $user->filterSearches()->create([
            'name' => $name,
            'vehicle_type' => StockVehicle::class,
            'filters' => $this->filters
        ]);

        $this->emit('filterSaved');
    }
}
