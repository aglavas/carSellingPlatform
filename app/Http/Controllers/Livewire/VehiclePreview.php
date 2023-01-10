<?php

namespace App\Http\Controllers\Livewire;

use Livewire\Component;

class VehiclePreview extends Component
{
    public $vehicle;
    public $resource;

    public $listeners = ['previewVehicle'];

    public function render()
    {
        return view('frontend.livewire.vehicle-preview');
    }

    public function previewVehicle($id) {
        $this->vehicle = $this->resource::find($id);
    }
}
