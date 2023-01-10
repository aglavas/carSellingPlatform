<?php

namespace App\Http\Controllers\Livewire;

use Livewire\Component;

class Styleguide extends Component
{
    public function render()
    {
        return view('frontend.livewire.styleguide')->layout('frontend.layouts.app');
    }
}
