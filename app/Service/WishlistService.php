<?php

namespace App\Service;

use App\WishlistItems;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Auth;
use App\Transaction;

class WishlistService
{
    /**
     * @var WishlistItems
     */
    private $wishlist;

    /**
     * @var \Illuminate\Contracts\Auth\Authenticatable|null
     */
    private $user;

    /**
     * WishlistService constructor.
     * @param WishlistItems $wishlistItems
     */
    public function __construct(WishlistItems $wishlistItems)
    {
        $this->wishlist = $wishlistItems;
        $this->user = Auth::user();
    }

    /**
     * Check if vehicle already in whislist
     *
     * @param Model $vehicle
     * @return mixed
     */
    public function checkIfVehicleInWishlist(Model $vehicle)
    {
        $identColumn = $vehicle->identColumn;

        $result = $this->wishlist->where('user_id', $this->user->id)->where('vehicle_ident', $vehicle->$identColumn)->where('vehicle_type', get_class($vehicle))->count();

        return $result;
    }

    /**
     * Get wishlist items
     *
     * @return mixed
     */
    public function getWishlistItems()
    {
        $this->user->load('wishlistItems');

        $wishlistItemCollection = $this->user->wishlistItems;

        foreach ($wishlistItemCollection as $key => $wishlistItem) {
            if ($wishlistItem->vehicle->enquiry_status === Transaction::VEHICLE_STATUS_RESERVED) {
                $wishlistItemCollection->forget($key);
            }
        }

        return $wishlistItemCollection;
    }

    /**
     * Get wishlist item count
     *
     * @return int
     */
    public function getWishlistItemCount()
    {
        $wishlistItemCollection = $this->getWishlistItems();

        return count($wishlistItemCollection);
    }
}
