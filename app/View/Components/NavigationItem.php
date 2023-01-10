<?php

namespace App\View\Components;

use Illuminate\View\Component;

class NavigationItem extends Component
{
    public $link, $icon, $label, $target;

    /**
     * Create a new component instance.
     *
     * @return void
     */
    public function __construct($link, $icon, $label, $target = '')
    {
        $this->link = $link;
        $this->icon = $icon;
        $this->label = $label;
        $this->target = $target;
    }

    /**
     * Get the view / contents that represent the component.
     *
     * @return \Illuminate\Contracts\View\View|string
     */
    public function render()
    {
        return view('components.navigation-item');
    }
}
