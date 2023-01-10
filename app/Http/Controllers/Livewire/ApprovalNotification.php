<?php

namespace App\Http\Controllers\Livewire;

use Livewire\Component;

class ApprovalNotification extends Component
{
    /**
     * @var bool
     */
    public $show = false;

    /**
     * @var array
     */
    protected $listeners = ['hideApprovalNotification'];

    /**
     * Mount the component
     *
     * @param $type
     */
    public function mount($type)
    {
        if ($type === 'seller') {
            $this->show = true;
        }
    }

    /**
     * Render the component
     *
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View
     */
    public function render()
    {
        return view('frontend.livewire.approval-notification');
    }

    /**
     * Hide approval notification
     */
    public function hideApprovalNotification()
    {
        $this->show = false;
    }
}
