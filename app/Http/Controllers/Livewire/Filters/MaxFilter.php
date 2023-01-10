<?php

namespace App\Http\Controllers\Livewire\Filters;

use App\Traits\WithFilterableOptions;
use Illuminate\Database\Eloquent\Model;
use Livewire\Component;

class MaxFilter extends Component
{
    use WithFilterableOptions;

    /**
     * @var
     */
    public $column, $label, $filter, $value, $labelBy;

    /**
     * @var Model
     */
    public $resource;

    /**
     * @var array
     */
    public $options = [];

    /**
     * @var array
     */
    protected $listeners = ['refreshFilter'];

    /**
     * @param Model $resource
     */
    public function mount(Model $resource)
    {
        $this->resource = $resource;

        $options = $this->resource->select($this->column)->groupBy($this->column)->get()->pluck($this->column,
            $this->column)->sort()->filter();
        $this->options = generate_range($options->min(), $options->max());
        $this->value = request()->input($this->filter);
    }

    /**
     * Toggle max filter
     *
     * @param $value
     */
    public function toggle($value)
    {
        $this->value = intval($value);
        $this->emit('filterToggled', ['column' => $this->column, 'values' => $value]);
    }

    /**
     * Refresh filter
     *
     * @param $filters
     * @param bool $reset
     */
    public function refreshFilter($filters, $reset = false)
    {
        $options = $this->resource->select($this->column)->groupBy($this->column);
        $options = $this->applyFilters($options, $filters, $this->column)->get()->pluck($this->column,
            $this->column)->sort()->filter();
        $this->options = generate_range($options->min(), $options->max());
        if ($reset) {
            $this->value = config("carmarket.frontend.filters")[$this->filter]['values'];
        }
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
     * Render the component
     *
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View
     */
    public function render()
    {
        return view('frontend.livewire.filters.max-filter');
    }
}
