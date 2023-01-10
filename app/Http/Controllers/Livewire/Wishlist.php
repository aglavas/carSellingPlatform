<?php

namespace App\Http\Controllers\Livewire;

use App\Service\WishlistService;
use App\WishlistItems;
use Illuminate\Database\Eloquent\Model;
use Livewire\Component;
use Illuminate\Support\Facades\Auth;

class Wishlist extends Component
{
    /**
     * @var Model
     */
    public $vehicle;

    /**
     * @var WishlistService
     */
    private $wishlistService;

    /**
     * @var array
     */
    protected $rules = [
        'vehicle' => 'required|forWishlist',
    ];

    /**
     * Mount component
     *
     * @param WishlistService $wishlistService
     */
    public function mount(WishlistService $wishlistService)
    {
        $this->wishlistService = $wishlistService;
    }

    /**
     * Render component
     *
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View
     */
    public function render()
    {
        $wishListService = app(WishlistService::class);

        if ($wishListService->checkIfVehicleInWishlist($this->vehicle)) {
            return view('frontend.livewire.wishlist.remove');
        }

        return view('frontend.livewire.wishlist.add');
    }

    /**
     * Remove from cart
     */
    public function remove()
    {
        $ident = $this->vehicle->identColumn;

        WishlistItems::where([
            'vehicle_type' => get_class($this->vehicle),
            'vehicle_ident' => $this->vehicle->$ident,
            'user_id' => Auth::user()->id,
        ])->first()->delete();

        $this->emit('wishlistCountChanged');
        $this->dispatchBrowserEvent('wishlist-count-changed');
    }

    /**
     * Add to cart
     */
    public function add()
    {
        $this->validate();

        $ident = $this->vehicle->identColumn;

        WishlistItems::firstOrCreate(
            [
                'vehicle_type' => get_class($this->vehicle),
                'vehicle_ident' => $this->vehicle->$ident,
                'user_id' => Auth::user()->id,
            ]
        );

        $this->emit('wishlistCountChanged');
        $this->dispatchBrowserEvent('wishlist-count-changed');
    }
}
