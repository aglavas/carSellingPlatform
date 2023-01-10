<?php

namespace App\Http\Controllers\Livewire;

use App\StockUsedCentralEurope;
use Livewire\Component;


class BrandSelect extends Component
{
    public $options;

    public $selected = [];

    public function mount() {
        $this->selected = request()->input('brand', []);
    }

    public function render()
    {
        $this->options = select_options_for(StockUsedCentralEurope::class, 'brand');
        return view('frontend.livewire.brand-select');
    }

    public function toggle($value)
    {
        $existsInArray = array_search($value, $this->selected);

        if ($existsInArray === false) {
            $this->selected[] = $value;
        } else {
            unset($this->selected[$existsInArray]);
        }
        $this->emitUp('filterToggled', ['column' => 'brand', 'values' => array_values($this->selected)]);
    }
}
