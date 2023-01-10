<?php

namespace App\Http\Controllers\Livewire;

use App\CartItem;
use App\StockVehicle;
use App\User;
use Illuminate\Support\Facades\Auth;
use Livewire\Component;
use App\Service\EnquiryService;

class VehicleCard extends Component
{
    /**
     * @var StockVehicle
     */
    public $vehicle;

    /**
     * @var array
     */
    public $selectedRows;

    /**
     * @var bool
     */
    public $selected = false;

    /**
     * @var bool
     */
    public $inCart = false;

    /**
     * @var bool
     */
    public $inEnquiry = false;

    /**
     * @var bool
     */
    public $denied = false;

    /**
     * @var string
     */
    public $manufacturerId;

    /**
     * Mount the component
     */
    public function mount()
    {
        if ($this->vehicle->isBookmarked()) {
            $this->selected = true;
        }

        if ($this->vehicle->cartData) {
            $this->inCart = true;
        }

        if ($this->vehicle->enquiryData) {
            $this->inEnquiry = true;
        }

        if ($this->vehicle->deniedEnquiryData) {
            $this->denied = true;
        }
    }

    /**
     * Get dynamic listeners
     *
     * @return array
     */
    protected function getListeners()
    {
        return ['cardCartChange:' . $this->manufacturerId => 'cardCartChange'];
    }

    /**
     * Card cart change
     *
     * @param $manufacturerId
     * @param $value
     */
    public function cardCartChange($manufacturerId, $value)
    {
        if ($this->manufacturerId === $manufacturerId) {
            $this->selected = false;
            $this->inCart = $value;
            $this->render();
        }
    }

    /**
     * Preview the vehicle
     *
     * @param $vehicleId
     */
    public function previewVehicle($vehicleId)
    {
        $this->emit('showSlideOver', $vehicleId);
    }

    /**
     * Preview the vehicle
     *
     * @param $manufacturerId
     */
    public function select($manufacturerId)
    {
        /** @var User $user */
        $user = Auth::user();

        $result = StockVehicle::where('manufacturer_id', $manufacturerId)->exists();

        if ($result) {
            $user->bookmarks()->syncWithoutDetaching($manufacturerId);
        }

        $this->selected = true;

        $this->emit('refreshSelectedCount');
    }

    /**
     * Preview the vehicle
     *
     * @param $manufacturerId
     */
    public function unSelect($manufacturerId)
    {
        /** @var User $user */
        $user = Auth::user();

        $result = StockVehicle::where('manufacturer_id', $manufacturerId)->exists();

        if ($result) {
            $user->bookmarks()->detach($manufacturerId);
        }

        $this->selected = false;

        $this->emit('refreshSelectedCount');
    }

    /**
     * Add vehicle to cart
     */
    public function addToCart()
    {
        $ident = $this->vehicle->identColumn;

        if (EnquiryService::validateEnquiry($this->vehicle) && !$this->vehicle->inCart()) {
            CartItem::firstOrCreate(
                [
                    'vehicle_type' => get_class($this->vehicle),
                    'user_id' => Auth::user()->id,
                    'vehicle_ident' => $this->vehicle->$ident
                ]
            );

            $this->inCart = true;
        }

        $this->emit('cartCountChanged');
        $this->dispatchBrowserEvent('cart-count-changed');

        $this->render();
    }

    /**
     * Remove from cart
     */
    public function removeFromCart()
    {
        $ident = $this->vehicle->identColumn;

        $cartItem = CartItem::where([
            'vehicle_type' => get_class($this->vehicle),
            'user_id' => Auth::user()->id,
            'vehicle_ident' => $this->vehicle->$ident
        ])->first();

        if ($cartItem) {
            $cartItem->delete();

            $this->inCart = false;
        }

        $this->emit('cartCountChanged');
        $this->dispatchBrowserEvent('cart-count-changed');

        $this->render();
    }

    /**
     * Render the component
     *
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View
     */
    public function render()
    {
        return view('frontend.livewire.vehicle-card');
    }
}
