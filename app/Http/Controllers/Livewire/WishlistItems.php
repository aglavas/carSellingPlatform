<?php

namespace App\Http\Controllers\Livewire;

use Illuminate\Database\Eloquent\Collection;
use Livewire\Component;

class WishlistItems extends Component
{
    /**
     * @var Collection
     */
    public $wishlistItems;

    /**
     * @var int
     */
    public $previewId;

    /**
     * Mount the component
     *
     * @param $wishlistItems
     */
    public function mount($wishlistItems)
    {
        $this->wishlistItems = $wishlistItems;
    }

    /**
     * Render the component
     *
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View
     */
    public function render()
    {
        return view('frontend.livewire.wishlist-items');
    }

    /**
     * Preview vehicle
     *
     * @param int $wishlistItemId
     */
    public function previewVehicle(int $wishlistItemId)
    {
        $wishlistItem = \App\WishlistItems::findOrFail($wishlistItemId);

        $vehicle = new $wishlistItem->vehicle_type;

        $vehicleId = $wishlistItem->vehicle_id;

        $vehicle = $vehicle::findOrFail($vehicleId);
        $view = view('frontend.vehicle-preview', [
            'vehicle' => $vehicle
        ])->render();
        $this->previewId = $vehicleId;
        $this->emit('showSlideOver', $view);
    }
}
