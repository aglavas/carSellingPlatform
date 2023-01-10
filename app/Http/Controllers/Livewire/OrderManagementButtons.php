<?php

namespace App\Http\Controllers\Livewire;

use Livewire\Component;

class OrderManagementButtons extends Component
{
    public $transaction;

    public function render()
    {
        return view('frontend.livewire.order-management-buttons');
    }
}
