<?php

namespace App\View\Components;

use Illuminate\View\Component;

class IconLink extends Component
{
    public $text, $icon, $link, $disabled;

    /**
     * Create a new component instance.
     *
     * IconLink constructor.
     * @param $text
     * @param $icon
     * @param string $link
     * @param bool $disabled
     */
    public function __construct($text, $icon, $link='', $disabled = false)
    {
        $this->text = $text;
        $this->icon = $icon;
        $this->link = $link;
        $this->disabled = $disabled;
    }

    /**
     * Get the view / contents that represent the component.
     *
     * @return \Illuminate\View\View|string
     */
    public function render()
    {
        return view('components.icon-link');
    }
}
