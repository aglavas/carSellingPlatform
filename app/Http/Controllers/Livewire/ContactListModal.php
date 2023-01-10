<?php

namespace App\Http\Controllers\Livewire;

use App\StockVehicle;
use Illuminate\Support\Collection;
use Livewire\Component;

class ContactListModal extends Component
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
    public $users;

    /**
     * @var array
     */
    protected $listeners = ['showContacts'];

    /**
     * Show contact modal
     *
     * @param string $manufacturerId
     */
    public function showContacts(string $manufacturerId)
    {
        /** @var StockVehicle $vehicle */
        $vehicle = StockVehicle::where('manufacturer_id', $manufacturerId)->first();

        if ($vehicle) {
            $this->company = $vehicle->company;
            $this->users = $vehicle->sellerContacts();
            $this->show = true;
        } else {
            $this->users = null;
            $this->show = false;
        }
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
        return view('frontend.livewire.contact-list-modal');
    }
}
