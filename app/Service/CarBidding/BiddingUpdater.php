<?php

namespace App\Service\CarBidding;

use App\StockVehicle;
use Illuminate\Support\Facades\Auth;

class BiddingUpdater
{
    /**
     * Vehicle changed check
     *
     * @param StockVehicle $stockVehicle
     * @return bool
     */
    public static function vehicleChanged(StockVehicle $stockVehicle)
    {
        $user = Auth::user();

        $mappingArray = config('carmarket.imports.used.cz.mappings');

        $companyId = $mappingArray['company_data']['company_id'];

        if (($user->stock_type === 'NC' && $user->import_types === 'I') || ($user->company_id == $companyId)) {
            $stockVehicle->addToSettings([
                'bidding_status' => StockVehicle::STATUS_SYNC_DONT_SYNC
            ]);

            return true;
        }

        $newPrice = $stockVehicle->b2b_price_ex_vat;

        $potentialLastPrice = $stockVehicle->getFromSettings('b2b_price_ex_vat');

        if (!$potentialLastPrice) {
            $stockVehicle->addToSettings([
                'b2b_price_ex_vat' => $newPrice
            ]);

            return true;
        }

        if ($newPrice != $potentialLastPrice) {
            $stockVehicle->addToSettings([
                'b2b_price_ex_vat' => $newPrice,
                'bidding_status' => null
            ]);

            return true;
        }

        return true;
    }
}
