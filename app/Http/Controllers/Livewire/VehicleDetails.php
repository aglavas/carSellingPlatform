<?php

namespace App\Http\Controllers\Livewire;

use App\Company;
use App\Repositories\VehicleRepository;
use App\StockVehicle;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Support\Facades\Auth;
use Livewire\Component;

class VehicleDetails extends Component
{
    /**
     * @var StockVehicle
     */
    public $vehicle;

    /**
     * @var Company
     */
    public $company;

    /**
     * @var Collection
     */
    public $users;

    /**
     * @var integer
     */
    public $biddingPrice = null;

    /**
     * @var string
     */
    public $currency = null;

    /**
     * Mount the component
     *
     * @param StockVehicle $vehicle
     * @param VehicleRepository $vehicleRepository
     */
    public function mount(StockVehicle $vehicle, VehicleRepository $vehicleRepository)
    {
        $this->vehicle = $vehicle;

        $this->company = $vehicle->getCompanyObject();

        $this->users = $vehicle->sellerContacts();

        $user = Auth::user();

        $usersCountry = $user->getCountry();

        list($biddingPrice, $currency) = $vehicleRepository->getPriceWithFee($vehicle, $usersCountry);

        if ($biddingPrice) {
            $this->biddingPrice = $biddingPrice;
            $this->currency = $currency;
        }

        $address = $this->company->address;
    }

    /**
     * Render the component
     *
     * @return mixed
     */
    public function render()
    {
        return view('frontend.livewire.vehicle-details')->layout('frontend.layouts.app');
    }
}
