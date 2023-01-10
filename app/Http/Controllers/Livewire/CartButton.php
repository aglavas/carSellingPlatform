<?php

namespace App\Http\Controllers\Livewire;

use App\CartItem;
use App\Service\EnquiryService;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Auth;
use Livewire\Component;
use Illuminate\Support\Facades\Route;

class CartButton extends Component
{
    /**
     * @var Model
     */
    public $vehicle;

    /**
     * @var bool
     */
    public $fullWidth = false;

    /**
     * @var bool
     */
    public $disabled = false;

    /**
     * @var bool
     */
    public $cartPage = false;

    /**
     * @var bool
     */
    public $icon = false;

    /**
     * @var array
     */
    protected $rules = [
        'vehicle' => 'required|purchasable',
    ];

    /**
     * @var array
     */
    protected $listeners = ['remove' => 'render', 'add' => 'render', 'cartCountChanged' => 'render'];

    /**
     * Render component
     *
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View
     */
    public function render()
    {
        $namespace = '';

        if ($this->icon) {
            $namespace = 'icons';
        }

        if ($this->vehicle->inCart()) {
            return view("frontend.livewire.cart-button.$namespace.remove");
        } elseif (!EnquiryService::validateEnquiry($this->vehicle)) {
            return view("frontend.livewire.cart-button.$namespace.disabled");
        }

        return view("frontend.livewire.cart-button.$namespace.add");
    }

    /**
     * Remove from cart
     */
    public function remove()
    {
        $ident = $this->vehicle->identColumn;

        $cartItem = CartItem::where([
            'vehicle_type' => get_class($this->vehicle),
            'user_id' => Auth::user()->id,
            'vehicle_ident' => $this->vehicle->$ident
        ])->first();

        if ($cartItem) {
            $cartItem->delete();
        }

        $manufacturerId = $this->vehicle->$ident;

        $this->emit('cardCartChange:' . $manufacturerId, $manufacturerId, false);
        $this->emit('cartCountChanged');
        $this->dispatchBrowserEvent('cart-count-changed');
        $this->emitSelf('remove');

        if ($this->cartPage) {
            return redirect()->route('cart.index');
        }
    }

    /**
     * Add to cart
     */
    public function add()
    {
        $this->validate();

        $ident = $this->vehicle->identColumn;

        CartItem::firstOrCreate(
            [
                'vehicle_type' => get_class($this->vehicle),
                'user_id' => Auth::user()->id,
                'vehicle_ident' => $this->vehicle->$ident
            ]
        );

        $manufacturerId = $this->vehicle->$ident;

        $this->emit('cardCartChange:' . $manufacturerId, $manufacturerId, true);
        $this->emit('cartCountChanged');
        $this->dispatchBrowserEvent('cart-count-changed');
        $this->emitSelf('add');
    }
}
