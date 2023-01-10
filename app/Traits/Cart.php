<?php

namespace App\Traits;

use App\CartItem;
use App\StockVehicle;
use Illuminate\Support\Facades\Auth;

trait Cart
{
    /**
     * In cart
     *
     * @return mixed
     */
    public function inCart()
    {
        $identColumn = $this->identColumn;

        return CartItem::where('user_id', Auth::user()->id)
            ->where('vehicle_type', StockVehicle::class)
            ->where('vehicle_ident', $this->$identColumn)->first();
    }
}
