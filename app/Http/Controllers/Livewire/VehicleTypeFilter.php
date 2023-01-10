<?php

namespace App\Http\Controllers\Livewire;

use Livewire\Component;

class VehicleTypeFilter extends Component
{
    /**
     * @var array
     */
    public $options = [];

    /**
     * @var string
     */
    public $status;

    /**
     * @var array
     */
    protected $listeners = ['refreshVehicleType'];

    /**
     * Mount the component
     */
    public function mount()
    {
        $this->status = request()->input('vehicle_type', 'all');

        $this->options = [
            'all' => 'All types',
            'used' => 'Used Cars',
            'new' => 'New Cars',
        ];
    }

    /**
     * Refresh transaction status
     *
     * @param $status
     */
    public function refreshVehicleType($status)
    {
        if (!$status) {
            $this->status = 'all';
        }

        $this->status = $status;

        $this->render();
    }

    /**
     * Apply selection
     *
     * @param $key
     */
    public function apply($key)
    {
        $this->status = $key;

        $this->emit('filterToggled', ['column' => 'vehicle_type', 'values' => $this->status]);
    }

    /**
     * Render the component
     *
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View
     */
    public function render()
    {
        return view('frontend.livewire.vehicle-type-filter');
    }
}
