<?php

namespace App\Traits;

use App\Exceptions\NCUserBrandMissing;
use App\Exceptions\UserStockTypeMissing;
use App\Exceptions\UserVehicleTypeMissing;
use App\Exceptions\UserWithoutCompanyException;

trait UserImportData
{
    /**
     * Get user import data
     *
     * @return array
     * @throws NCUserBrandMissing
     * @throws UserStockTypeMissing
     * @throws UserVehicleTypeMissing
     * @throws UserWithoutCompanyException
     */
    public static function getUserImportData()
    {
        $user = auth()->user();

        $vpvu = $user->vehicle_type;

        if (!$user->company_id) {
            throw new UserWithoutCompanyException();
        }

        if (!$vpvu || !count($vpvu)) {
            throw new UserVehicleTypeMissing();
        }

        $stockType = $user->stock_type;

        if (!$stockType) {
            throw new UserStockTypeMissing();
        }

        $brandArray = [];

        if ($stockType === 'NC' || $stockType === 'both') {
            $user->load('brands');

            $brandCollection = $user->brands;

            if (!count($brandCollection)) {
                throw new NCUserBrandMissing();
            }

            $brandArray = $brandCollection->pluck('name')->toArray();

            foreach ($brandArray as &$brand) {
                $brand = strtoupper(trim($brand));
            }
        }

        return [$vpvu, $stockType, $brandArray];
    }
}
