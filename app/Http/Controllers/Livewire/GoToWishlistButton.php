<?php

namespace App\Http\Controllers\Livewire;

use App\Service\WishlistService;
use Livewire\Component;

class GoToWishlistButton extends Component
{
    /**
     * @var int
     */
    public $itemCount = 0;

    /**
     * @var array
     */
    protected $listeners = ['wishlistCountChanged' => 'updateItemCount'];

    /**
     * Render the component
     *
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View
     */
    public function render()
    {
        $wishlistService = app(WishlistService::class);

        $this->itemCount = $wishlistService->getWishlistItemCount();
        return view('frontend.livewire.go-to-wishlist-button');
    }

    /**
     * Update wishlist count
     */
    public function updateItemCount()
    {
        $wishlistService = app(WishlistService::class);

        $this->itemCount = $wishlistService->getWishlistItemCount();
    }
}
