<?php

namespace App\Http\Controllers;

use App\Service\WishlistService;
use Illuminate\Http\Request;

class WishlistController extends Controller
{
    /**
     * List wishlist items
     *
     * @param Request $request
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View
     */
    public function list(Request $request, WishlistService $wishlistService)
    {
        $wishlistItemCollection = $wishlistService->getWishlistItems();

        return view('frontend.wishlist.list', [
            'wishlistItems' => $wishlistItemCollection,
        ]);
    }
}
