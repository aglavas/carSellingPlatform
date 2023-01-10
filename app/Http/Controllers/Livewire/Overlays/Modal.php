<?php

namespace App\Http\Controllers\Livewire\Overlays;

use Livewire\Component;

class Modal extends Component
{
    public $content = null;

    public $listeners = ['showModal', 'closeModal'];

    public function render()
    {
        return view('frontend.livewire.overlays.modal');
    }

    public function showModal($content)
    {
        $this->content = $content;
    }

    public function closeModal() {
        $this->content = null;
    }
}
