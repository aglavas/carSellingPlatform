<?php

namespace App\Http\Controllers\Livewire;

use Illuminate\Support\Facades\Auth;
use Livewire\Component;

class SelectedCount extends Component
{
    /**
     * @var int
     */
    public $count = 0;

    /**
     * @var array
     */
    protected $listeners = ['refreshSelectedCount'];

    /**
     * Mount the component
     */
    public function mount()
    {
        $user = Auth::user();

        $this->count  = $user->bookmarks()->count();
    }

    /**
     * Render the component
     *
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View
     */
    public function render()
    {
        return view('frontend.livewire.selected-count');
    }

    /**
     * Refresh selected count
     */
    public function refreshSelectedCount()
    {
        $user = Auth::user();

        $this->count  = $user->bookmarks()->count();
    }
}
