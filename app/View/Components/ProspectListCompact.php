<?php

namespace App\View\Components;

use Illuminate\Support\Collection;
use Illuminate\View\Component;

class ProspectListCompact extends Component
{
    /**
     * @var Collection
     */
    public $prospects;

    /**
     * @var Collection
     */
    public $closedProspects;

    /**
     * ProspectListCompact constructor.
     * @param $prospects
     * @param $closedProspects
     */
    public function __construct($prospects, $closedProspects = [])
    {
        $this->prospects = $prospects;
        $this->closedProspects = $closedProspects;
    }

    /**
     * Get the view / contents that represent the component.
     *
     * @return \Illuminate\Contracts\View\View|string
     */
    public function render()
    {
        return view('components.prospect-list-compact');
    }
}
