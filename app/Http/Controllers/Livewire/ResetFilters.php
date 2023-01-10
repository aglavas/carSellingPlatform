<?php

namespace App\Http\Controllers\Livewire;

use Livewire\Component;
use Illuminate\Support\Facades\Route;

class ResetFilters extends Component
{
    /**
     * @var array
     */
    public $filters;

    /**
     * @var string
     */
    public $resetUrl;

    /**
     * @var array
     */
    protected $listeners = ['refreshResetFilters', 'resetFilter'];

    /**
     * Mount component
     */
    public function mount()
    {
        $this->resetUrl = route('vehicle-search');
    }

    /**
     * Render component
     *
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View
     */
    public function render()
    {
        return view('frontend.livewire.reset-filters');
    }

    /**
     * Refresh filter state
     *
     * @param $filters
     */
    public function refreshResetFilters($filters)
    {
        $this->filters = $filters;
    }

    /**
     * Reset filters
     *
     */
    public function resetFilter()
    {
        $this->redirect($this->resetUrl);
    }
}
