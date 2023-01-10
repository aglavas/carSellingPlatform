<?php

namespace App\Http\Controllers\Livewire;

use App\Service\AuthService;
use Livewire\Component;

class Analytics extends Component
{
    /**
     * @var string
     */
    public $period = 'all';

    /**
     * @var string
     */
    public $type;

    /**
     * @param $type
     */
    public function mount($type)
    {
        $this->type = $type;
    }

    /**
     * Render the component
     *
     * @return mixed
     */
    public function render()
    {
        return view("frontend.livewire.analytics.$this->type")->layout('frontend.layouts.app');
    }

    /**
     * Set period
     *
     * @param $period
     */
    public function setPeriod($period)
    {
        $this->period = $period;
    }
}
