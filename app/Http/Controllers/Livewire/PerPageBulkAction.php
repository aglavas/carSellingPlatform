<?php

namespace App\Http\Controllers\Livewire;

use Livewire\Component;

class PerPageBulkAction extends Component
{
    /**
     * @var int
     */
    public $perPage;

    /**
     * Mount the component
     *
     * @param int $perPage
     */
    public function mount($perPage = 40)
    {
        $this->perPage = $perPage;
    }

    /**
     * Render the component
     *
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View
     */
    public function render()
    {
        return view('frontend.livewire.per-page-bulk-action');
    }

    /**
     * Set per page
     *
     * @param $perPage
     */
    public function perPage($perPage)
    {
        $this->perPage = $perPage;

        $this->emit('refreshPerPage', $perPage);
    }
}
