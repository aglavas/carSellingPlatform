<?php

namespace App\Http\Controllers\Livewire;

use App\StockVehicle;
use Illuminate\Support\Collection;
use Livewire\Component;
use App\CartItem;
use Illuminate\Support\Facades\Auth;

class Cart extends Component
{
    /**
     * @var Collection
     */
    public $vehicleCollection;

    /**
     * @var Collection
     */
    public $displayCollection;

    /**
     * @var int
     */
    public $totalPrice;

    /**
     * Mount the component
     */
    public function mount()
    {
       $this->setCartValues();
    }

    /**
     * Render the component
     *
     * @return mixed
     */
    public function render()
    {
        return view('frontend.livewire.cart')->layout('frontend.layouts.app');
    }

    /**
     * Remove from cart
     *
     * @param $ident
     */
    public function removeFromCart($ident)
    {
        $cartItem = CartItem::where([
            'vehicle_type' => StockVehicle::class,
            'user_id' => Auth::user()->id,
            'vehicle_ident' => $ident
        ])->first();

        if ($cartItem) {
            $cartItem->delete();
        }

        $this->emit('cartCountChanged');
        $this->dispatchBrowserEvent('cart-count-changed');
        $this->emit('remove');

        $this->setCartValues();
    }

    /**
     * Set cart values
     */
    private function setCartValues()
    {
        $cartItemCollection = CartItem::with('vehicle')->where('user_id', Auth::user()->id)->get();

        $vehicleCollection = collect([]);

        $this->totalPrice = 0;

        foreach ($cartItemCollection as $cartItem) {
            $vehicle = $cartItem->vehicle;

            if (!$vehicle) {
                continue;
            }

            $vehicleCollection->push($vehicle);

            $price = $vehicle->price_in_euro;

            $this->totalPrice = $this->totalPrice + $price;
        }

        $this->vehicleCollection = $vehicleCollection;

        $displayCollection = $vehicleCollection;

        $displayCollection = $displayCollection->groupBy('company');

        $this->displayCollection = $displayCollection;
    }
}
