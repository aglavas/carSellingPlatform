<?php

namespace App\Http\Controllers\Livewire;

use Livewire\Component;

class BrandSelection extends Component
{
    /**
     * @var array
     */
    public $brands;

    /**
     * @var bool
     */
    public $showBrands = false;

    /**
     * @var array
     */
    protected $listeners = ['stock-type-selected' => 'stockTypeSelected'];

    /**
     * @param $type
     */
    public function stockTypeSelected($type)
    {
        if ($type === 'UC') {
            $this->showBrands = false;
        } else {
            $this->showBrands = true;
        }
    }

    /**
     * Render the component
     *
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View
     */
    public function render()
    {
        return view('frontend.livewire.brand-selection');
    }
}
