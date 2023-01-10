<?php

namespace App\Http\Controllers\Livewire;

use Illuminate\Database\Eloquent\Model;
use Livewire\Component;

class VehicleSearchFilterTable extends Component
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
     * Mount the component
     *
     * @param Model $resource
     * @param string $resourceClass
     * @param array $filters
     * @param $selectedFilter
     */
    public function mount(Model $resource, string $resourceClass, array $filters, $selectedFilter) {
        $this->resource = $resource;

        $this->resourceClass = $resourceClass;

        $this->filters = $filters;

        $this->selectedFilter = $selectedFilter;

        $this->resetUrl = url()->current();
    }

    /**
     * Render
     *
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View
     */
    public function render()
    {
        return view('frontend.livewire.vehicle-search-filter-table');
    }

    /**
     * Show save filter modal
     */
    public function showSaveFilterModal() {
        $this->emit('showModal', view('frontend.save-filter', [
            'resource' => $this->resource
        ])->render());
    }
}
