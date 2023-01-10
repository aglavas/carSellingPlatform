<?php

namespace App\View\Components\Frontend\Sidebar;

use Illuminate\View\Component;

class CollapsibleItem extends Component
{

    public $title;

    public $items;

    public $icon;

    public $iconColor;

    /**
     * Create a new component instance.
     *
     * @return void
     */
    public function __construct($title, $items, $icon, $iconColor='gray')
    {
        $this->title = $title;
        $this->items = $items;
        $this->icon = $icon;
        $this->iconColor = $iconColor;
    }

    /**
     * Get the view / contents that represent the component.
     *
     * @return \Illuminate\Contracts\View\View|string
     */
    public function render()
    {
        return view('frontend.sidebar.collapsible-item');
    }
}
