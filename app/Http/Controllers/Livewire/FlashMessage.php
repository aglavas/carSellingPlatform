<?php

namespace App\Http\Controllers\Livewire;

use Livewire\Component;

class FlashMessage extends Component
{
    /**
     * @var string
     */
    public $message = '';

    /**
     * @var bool
     */
    public $showMessage = false;

    /**
     * @var array
     */
    protected $listeners = ['flashMessage', 'show' => '$refresh'];

    /**
     * @param $message
     */
    public function flashMessage($message)
    {
        $this->message = $message;
        $this->showMessage = true;
        $this->emitSelf('show');
    }

    /**
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View
     */
    public function render()
    {
        return view('frontend.livewire.flash-message');
    }
}
