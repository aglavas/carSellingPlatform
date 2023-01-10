<?php

namespace App\Http\Controllers\Livewire;

use Illuminate\Database\Eloquent\Model;
use Livewire\Component;

class SaveFilterModal extends Component
{
    /**
     * @var
     */
    public $name;

    /**
     * @var string
     */
    public $resource;

    /**
     * @param  Model  $resource
     */
    public function mount(Model $resource)
    {
        $this->resource = get_class($resource);
    }

    /**
     * Render component
     *
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View
     */
    public function render()
    {
        return view('frontend.livewire.save-filter-modal');
    }

    /**
     * Save filters
     */
    public function saveFilters()
    {
        $this->emit('saveFilters', $this->name, $this->resource);
        $this->emit('closeModal');
    }
}
