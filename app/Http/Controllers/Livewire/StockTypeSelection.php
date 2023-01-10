<?php

namespace App\Http\Controllers\Livewire;

use Livewire\Component;

class StockTypeSelection extends Component
{
    /**
     * Render the component
     *
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View
     */
    public function render()
    {
        return view('frontend.livewire.stock-type-selection');
    }
}
