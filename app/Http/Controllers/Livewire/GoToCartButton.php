<?php

namespace App\Http\Controllers\Livewire;

use App\CartItem;
use Illuminate\Support\Facades\Auth;
use Livewire\Component;

class GoToCartButton extends Component
{

    public $itemCount = 0;

    protected $listeners = ['cartCountChanged' => 'updateItemCount'];

    public function render()
    {
        $this->itemCount = CartItem::where('user_id', Auth::user()->id)->count();
        return view('frontend.livewire.go-to-cart-button');
    }

    public function updateItemCount()
    {
        $this->itemCount = CartItem::where('user_id', Auth::user()->id)->count();
    }

}
