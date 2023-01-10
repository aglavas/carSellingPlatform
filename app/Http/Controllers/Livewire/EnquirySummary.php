<?php

namespace App\Http\Controllers\Livewire;

use App\Company;
use App\Enquiry;
use App\User;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Auth;
use Livewire\Component;

class EnquirySummary extends Component
{
    /**
     * @var Collection
     */
    public $enquiryItems;

    /**
     * @var integer
     */
    public $totalVehicles;

    /**
     * @var float
     */
    public $totalPrice;

    /**
     * @var Enquiry
     */
    public $enquiry;

    /**
     * @var User
     */
    public $user;

    /**
     * @var Company
     */
    public $company;

    /**
     * Mount the component
     *
     * @param $enquiryItems
     * @param $totalVehicles
     * @param $totalPrice
     * @param $enquiry
     */
    public function mount(Collection $enquiryItems, int $totalVehicles, float $totalPrice, Enquiry $enquiry)
    {
        $this->enquiryItems = $enquiryItems;

        $this->totalVehicles = $totalVehicles;

        $this->totalPrice = $totalPrice;

        $this->enquiry = $enquiry;

        $this->user = Auth::user();

        $this->company = $this->user->company;
    }

    /**
     * Render the component
     *
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View
     */
    public function render()
    {
        return view('frontend.livewire.enquiry-summary');
    }
}
