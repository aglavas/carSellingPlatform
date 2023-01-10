<?php

namespace App\Http\Controllers\Livewire;

use Livewire\Component;

class FilterActions extends Component
{
    /**
     * @var bool
     */
    public $selected = false;

    /**
     * @var array
     */
    protected $listeners = ['refreshActions'];

    /**
     * Mount component
     *
     * @param $selected
     */
    public function mount($selected)
    {
        $this->selected = $selected;
    }

    /**
     * Render component
     *
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View
     */
    public function render()
    {
        return view('frontend.livewire.filter-actions');
    }

    /**
     * Refresh actions
     *
     * @param $selected
     */
    public function refreshActions($selected)
    {
        $this->selected = $selected;

        $this->render();
    }
}
