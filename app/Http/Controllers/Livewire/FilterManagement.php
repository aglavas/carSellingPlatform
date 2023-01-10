<?php

namespace App\Http\Controllers\Livewire;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Collection;
use Livewire\Component;
use Illuminate\Support\Facades\Auth;
use App\FilterSearch;

class FilterManagement extends Component
{
    /**
     * @var Collection
     */
    private $filterCollection;

    /**
     * Is there saved filters. If is, show the list
     *
     * @var bool
     */
    public $show = false;

    /**
     * Currently selected filter
     *
     * @var null
     */
    public $selected = null;

    /**
     * @var Model
     */
    public $resource;

    /**
     * @var string
     */
    public $resourceClass;

    /**
     * @var array
     */
    protected $listeners = ['loadFilter', 'deleteFilter','filterSaved', 'filterSelected'];

    /**
     * Model $resource
     *
     * @param Model $resource
     * @param string $resourceClass
     * @param $selectedFilter
     */
    public function mount(Model $resource, string $resourceClass, $selectedFilter)
    {
        $this->resource = $resource;
        $this->resourceClass = $resourceClass;
        $this->selected = $selectedFilter;
    }

    /**
     * Render component
     *
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View
     */
    public function render()
    {
        $user = Auth::user();

        $filters = $user->getFilters(get_class($this->resource));

        if ($filters) {
            $this->show = true;

            $this->filterCollection = $filters;
        } else {
            $this->show = false;
            $this->selected = null;

            $this->emit('refreshActions', $this->selected);
            $this->emit('resetFilter');
        }

        return view('frontend.livewire.filter-management', [
            'filters' => $this->filterCollection
        ]);
    }

    /**
     * Delete filter
     */
    public function deleteFilter()
    {
        $filter = FilterSearch::findOrFail($this->selected);

        $filter->delete();

        $this->emit('flashMessage', 'Filter successfully deleted.');
        $this->emit('resetFilter');
    }

    /**
     * Refresh actions
     */
    public function filterSaved()
    {
        $this->emit('flashMessage', 'Filter successfully saved.');
    }

    /**
     * Filter selected action
     *
     * @param $value
     * @return bool
     */
    public function filterSelected($value)
    {
        if (empty($value)) {
            $this->emit('refreshActions', $this->selected);
            $this->emit('resetFilter');

            return true;
        }

        $this->emit('loadSelectedFilter', $value);
        return true;
    }
}
