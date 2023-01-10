<?php

namespace App\View\Components;

use Illuminate\View\Component;

class Card extends Component
{

    public $title;
    public $contentPadding;

    /**
     * Create a new component instance.
     *
     * @return void
     */
    public function __construct($title = '', $contentPadding = true)
    {
        $this->title = $title;
        $this->contentPadding = $contentPadding;
    }

    /**
     * Get the view / contents that represent the component.
     *
     * @return \Illuminate\Contracts\View\View|string
     */
    public function render()
    {
        return view('components.card');
    }
}
