<?php

namespace App\Http\Controllers\Livewire\Overlays;

use Livewire\Component;
use App\StockVehicle;

class SlideOver extends Component
{
    /**
     * @var null|StockVehicle
     */
    public $vehicle = null;

    public $content = null;

    /**
     * @var array
     */
    public $listeners = ['showSlideOver', 'showSlideOverContent', 'closeSlideOver'];

    /**
     * Render the component
     *
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View
     */
    public function render()
    {
        if ($this->content) {
            return view('frontend.livewire.overlays.slide-over-content');
        }

        return view('frontend.livewire.overlays.slide-over');
    }

    /**
     * Show the slideover
     */
    public function showSlideOver($vehicleId)
    {
        $this->content = null;

        $vehicle = StockVehicle::findOrFail($vehicleId);

        $this->vehicle = $vehicle;
    }

    /**
     * Show the slideover
     */
    public function showSlideOverContent($content)
    {
        $this->content = $content;
    }

    /**
     * Close the slideover
     */
    public function closeSlideOver() {
        $this->vehicle = null;
    }
}
