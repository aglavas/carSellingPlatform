<?php

namespace App\Service;

use App\Enquiry;
use App\Notifications\EnquiryStarted;
use App\StockUsedCentralEurope;
use App\StockVehicle;
use App\Transaction;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Notification;
use App\FrontendNotification;

class EnquiryService
{
    /**
     * @var Enquiry
     */
    private $enquiry;

    /**
     * @var \Illuminate\Contracts\Auth\Authenticatable|null
     */
    private $user;

    /**
     * EnquiryService constructor.
     * @param Enquiry $enquiry
     */
    public function __construct(Enquiry $enquiry)
    {
        $this->enquiry = $enquiry;

        $this->user = Auth::user();
    }

    /**
     * Handle enquiry
     *
     * @param Collection $enquiryItems
     * @return Enquiry
     */
    public function handleEnquiry(Collection $enquiryItems)
    {
        $contacts = [];

        DB::beginTransaction();

        try {
            /** @var Enquiry $enquiry */
            $enquiry = $this->enquiry->create([
                'user_id' => $this->user->id,
                'status' => Enquiry::STATUS_IN_PROGRESS
            ]);

            foreach ($enquiryItems as $enquiryItem) {
                /** @var StockVehicle $vehicle */

                $vehicle = $enquiryItem->vehicle;

                $contactsCollection = $vehicle->sellerContacts();

                $contactEntity = $contactsCollection->first();

                if (!$contactEntity) {
                    continue;
                }

                $emailArray = $contactsCollection->pluck('email')->toArray();

                $contacts = array_merge($contacts, $emailArray);

                $vehicleIdent = $vehicle->identColumn;

                $enquiry->transactions()->create([
                    'buyer_id' => $this->user->id,
                    'seller_company_id' => $contactEntity->company_id,
                    'car_data' => $vehicle->getAttributes(),
                    'country' => strtoupper($vehicle->country),
                    'status' => Transaction::TRANSACTION_STATUS_IN_PROGRESS,
                    'vehicle_type' => get_class($vehicle),
                    'vehicle_ident' => $vehicle->$vehicleIdent
                ]);

                FrontendNotification::create([
                    'causer_id' => $this->user->id,
                    'type' => FrontendNotification::ENQUIRY_STARTED,
                    'user_type' => FrontendNotification::USER_SELLER,
                    'country' => strtoupper($vehicle->country),
                    'company_id' => $contactEntity->company_id,
                ]);
            }

            $contacts = array_unique($contacts);

            foreach ($contacts as $contact) {
                Notification::route('mail', $contact)->notify(new EnquiryStarted($enquiry, $this->user));
            }

            $this->user->cartItems()->delete();
        } catch (\Exception $exception) {
            DB::rollBack();
            activity('carmarket')
                ->withProperties(['error' => $exception->getMessage(), 'enquiryItem' => $enquiryItem])
                ->log('Enquiry failed.');
        }

        DB::commit();

        return $enquiry;
    }

    /**
     * Get transactions
     *
     * @return array
     */
    public function getTransactions() {
        $allTransactions = Transaction::get();
        $sellerTransactions = Transaction::where('seller_company_id', $this->user->company->id)->where(
            'country',
            $this->user->country
        )->get();
        $this->user->load('enquiry');
        return [
            'admin' => $allTransactions,
            'seller' => $sellerTransactions,
            'buyer' => data_get($this->user->enquiry, '*.transactions.*')
        ];
    }

    /**
     * Group enquiry items per company
     *
     * @param Collection $enquiryItems
     * @return array
     */
    public function groupEnquiryItems(Collection $enquiryItems)
    {
        $vehicleCollection = collect([]);

        $totalVehicles = 0;
        $totalPrice = 0;

        /** @var StockVehicle $enquiryItem */
        foreach ($enquiryItems as $enquiryItem) {
            $enquiryItem->vehicle->load('ownerCompany');

            /** @var StockVehicle $vehicle */
            $vehicle = $enquiryItem->vehicle;
            $vehicle->contacts = $vehicle->sellerContacts();

            $vehicleCollection->push($vehicle);
            $totalVehicles++;
            $totalPrice += $enquiryItem->vehicle->price_in_euro;
        }

        return [$vehicleCollection, $totalVehicles, $totalPrice];
    }

    /**
     * Validate enquiry
     *
     * @param Model $vehicle
     * @return bool
     */
    public static function validateEnquiry(Model $vehicle)
    {
        //Get open transactions of vehicle, and check if the user has open trasnaction of vehicle

        $vehicleTransactionCollection = $vehicle->openTransactions();

        $vehicleTransactionIdArray = $vehicleTransactionCollection->pluck('id')->toArray();

        $userTransactions = Transaction::ofUser()->get();

        $userTransactionIdArray = $userTransactions->pluck('id')->toArray();

        $resultArray = array_intersect($vehicleTransactionIdArray, $userTransactionIdArray);

        if (count($resultArray)) {
            return false;
        }

        return true;
    }
}
