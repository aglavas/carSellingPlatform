<?php

namespace App\Export;

use App\StockVehicle;
use App\Transaction;
use Illuminate\Database\Eloquent\Model;

class TransactionExport
{
    /**
     * Prepare export data
     *
     * @param Model $model
     * @return array
     */
    public function prepareExport(Model $model)
    {
        $vehicle = $model->vehicle;

        if (!$vehicle) {
            $vehicle = (object) $model->car_data;

            $model->vehicle = $vehicle;
        }

        $vehicle = $model->vehicle;

        $resultArray = [
            'Status' => $model->status,
            'Enquiry Id' => $model->enquiry_id,
            'Vehicle Type' => $this->getVehicleType(),
            'Vehicle' => $this->getVehicleData($model),
            'Price' => $this->getVehiclePrice($model),
            'Company' => $this->getVehicleCompany($model),
            'Identifier' => $this->getVehicleIdentifier($model),
            'Last Update' => $model->updated_at->format('d.m.Y H:i'),
        ];

        if ($model->list_type === 'buyer') {

            if ($vehicle instanceof \stdClass) {
                $resultArray = array_merge($resultArray, [
                    'Sellers' => ''
                ]);
            } else {
                $vehicle = $model->vehicle;

                $contactCollection = $vehicle->sellerContacts();

                $sellers = "";

                foreach ($contactCollection as $contact) {
                    $sellers = "$contact->name, $contact->email, $contact->telephone";
                }

                $resultArray = array_merge($resultArray, [
                    'Sellers' => $sellers
                ]);
            }

        } elseif ($model->list_type === 'admin') {
            if ($vehicle instanceof \stdClass) {
                $resultArray = array_merge($resultArray, [
                    'Sellers' => '',
                    'Buyer' => '',
                ]);
            } else {
                $vehicle = $model->vehicle;

                $contactCollection = $vehicle->sellerContacts();

                $sellers = "";

                foreach ($contactCollection as $contact) {
                    $sellers = "$contact->name, $contact->email, $contact->telephone";
                }

                $resultArray = array_merge($resultArray, [
                    'Sellers' => $sellers,
                    'Buyer' => $model->buyer->name,
                ]);
            }

        } else {
            if ($vehicle instanceof \stdClass) {
                $resultArray = array_merge($resultArray, [
                    'Prospects' => ''
                ]);
            } else {
                if ($model->status === 'approved') {
                    $resultArray = array_merge($resultArray, [
                        'Prospects' => $this->getVehicleProspects($model, true)
                    ]);
                } else {
                    $resultArray = array_merge($resultArray, [
                        'Prospects' => $this->getVehicleProspects($model)
                    ]);
                }
            }
        }

        return $resultArray;
    }

    /**
     * Get vehicle company
     *
     * @param Model $model
     * @return mixed
     */
    private function getVehicleProspects(Model $model, $approved = false)
    {
        $vehicle = $model->vehicle;

        if ($approved) {
            $transaction = $vehicle->approvedTransactions()->first();

            $buyer = $transaction->buyer;

            $company = $buyer->company->name;

            $prospectString = "$buyer->name - $buyer->email - $company";
        } else {
            $prospects = $vehicle->openProspects();

            if (count($prospects) === 0) {
                return '0 prospects';
            } else {
                $prospectString = "";

                foreach ($prospects as $prospect) {
                    $name = $prospect['user']->name;
                    $company = $prospect['user']->company->name;
                    $count = $prospect['count'];
                    $prospectString = "$name - $company - Requested cars: $count";
                }
            }
        }

        return $prospectString;
    }

    /**
     * Get vehicle company
     *
     * @param Model $model
     * @return mixed
     */
    private function getVehicleCompany(Model $model)
    {
        if ($model->list_type === 'buyer') {
            $company = $model->company->name;
        } else {
            $buyer = $model->buyer;

            if ($buyer->company) {
                $company = $buyer->company->name;
            } else {
                $company = 'NA';
            }
        }

        return $company;
    }

    /**
     * Get vehicle prrice
     *
     * @param Model $model
     * @return int
     */
    private function getVehiclePrice(Model $model)
    {
        $vehicle = $model->vehicle;

        return $vehicle->price_in_euro;
    }

    /**
     * Get vehicle data
     *
     * @param Model $model
     * @return string
     */
    private function getVehicleData(Model $model)
    {
        $vehicle = $model->vehicle;

        try {
            $brand = $vehicle->brand;
            $model = $vehicle->model;
            $ident = $vehicle->manufacturer_id;
        } catch (\Exception $exception) {
            $test = 'fsdfds';
        }

        return "$brand $model $ident";
    }

    /**
     * Get vehicle identifier
     *
     * @param Model $model
     * @return string
     */
    private function getVehicleIdentifier(Model $model)
    {
        $vehicle = $model->vehicle;

        return $vehicle->manufacturer_id;
    }

    /**
     * Return vehicle type
     *
     * @return string
     */
    private function getVehicleType()
    {
        return StockVehicle::class;
    }
}
