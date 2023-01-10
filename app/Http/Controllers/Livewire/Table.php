<?php

namespace App\Http\Controllers\Livewire;

use Livewire\Component;

class Table extends Component
{
    public function render()
    {
        return view('frontend.livewire.table')->layout('frontend.layouts.app');
    }
}
