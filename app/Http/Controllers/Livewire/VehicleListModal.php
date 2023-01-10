<?php

namespace App\Http\Controllers\Livewire;

use Illuminate\Support\Collection;
use Livewire\Component;

class VehicleListModal extends Component
{
    /**
     * @var bool
     */
    public $show = false;

    /**
     * @var string
     */
    public $company;

    /**
     * @var Collection
     */
    public $enquiryItems;

    /**
     * @var array
     */
    protected $listeners = ['showVehicles'];

    /**
     * Show contact modal
     *
     * @param $company
     */
    public function showVehicles($company)
    {
        if ($company === $this->company) {
            $this->show = true;
        }
    }

    /**
     * Mount the component
     *
     * @param string $company
     * @param Collection $enquiryItems
     */
    public function mount(string $company, Collection $enquiryItems)
    {
        $this->company = $company;

        $this->enquiryItems = $enquiryItems;
    }

    /**
     * Close modal
     */
    public function closeModal()
    {
        $this->show = false;
    }

    /**
     * Render the component
     *
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View
     */
    public function render()
    {
        return view('frontend.livewire.vehicle-list-modal');
    }
}
