<?php

namespace App\View\Components;

use Illuminate\View\Component;

class DataListItem extends Component
{
    public $label, $value, $link;

    /**
     * Create a new component instance.
     *
     * @return void
     */
    public function __construct($label, $value, $link = false)
    {
        $this->label = $label;
        $this->value = $value;
        $this->link = $link;
    }

    /**
     * Get the view / contents that represent the component.
     *
     * @return \Illuminate\Contracts\View\View|string
     */
    public function render()
    {
        return view('components.data-list-item');
    }
}
