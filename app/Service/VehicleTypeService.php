<?php

namespace App\Service;

use App\Exceptions\UserVehicleTypeMissing;
use App\Exceptions\VehicleTypeImportMismatchException;
use App\Exceptions\VehicleTypeListMissing;
use App\Exceptions\VehicleTypeWrongValue;
use App\Imports\PreImport\StockVehiclePreImport;
use App\Imports\StockVehicleImport;
use App\StockVehicle;
use App\User;
use Livewire\TemporaryUploadedFile;
use Maatwebsite\Excel\Facades\Excel;

class VehicleTypeService
{
    /**
     * Pre import mapping
     *
     * @var array
     */
    public static $listTypePreImportMapping = [
        StockVehicleImport::class => StockVehiclePreImport::class
    ];

    /**
     * Resource mapping
     *
     * @var array
     */
    public static $listTypeResourceMapping = [
        StockVehicleImport::class => StockVehicle::class
    ];

    /**
     * Check vehicle type deletion
     *
     * @param string $list
     * @param TemporaryUploadedFile $uploadedList
     * @param User $user
     * @return array|bool
     * @throws UserVehicleTypeMissing
     * @throws VehicleTypeImportMismatchException
     * @throws VehicleTypeListMissing
     * @throws VehicleTypeWrongValue
     */
    public static function checkVehicleTypeDeletion(string $list, TemporaryUploadedFile $uploadedList, User $user)
    {
        $preImportListType =  self::$listTypePreImportMapping[$list];

        $listType = new $preImportListType;

        $parsedRows = Excel::toArray(new $listType, $uploadedList);

        $rows = $parsedRows[0];

        $heading = $rows[0];

        unset($rows[0]);

        $dataCollection = collect($rows);

        $heading = array_filter($heading);

        $vehicleTypeKeyIndex1 = array_search('VehicleType', $heading);

        $vehicleTypeKeyIndex2 = array_search('vehicletype', $heading);

        $vehicleTypeKeyIndex3 = array_search('Vehicle Type', $heading);

        if (!$vehicleTypeKeyIndex1 && !$vehicleTypeKeyIndex2 && !$vehicleTypeKeyIndex3) {
            $vehicleTypeKeyIndex = 'vehicletype';
        } else {
            if ($vehicleTypeKeyIndex1) {
                $vehicleTypeKeyIndex = $vehicleTypeKeyIndex1;
            } elseif ($vehicleTypeKeyIndex2) {
                $vehicleTypeKeyIndex = $vehicleTypeKeyIndex2;
            } else {
                $vehicleTypeKeyIndex = $vehicleTypeKeyIndex3;
            }
        }

        $vehicleTypeArray = [];

        try {
            foreach ($dataCollection as $dataRow) {
                array_push($vehicleTypeArray, $dataRow[$vehicleTypeKeyIndex]);
            }
        } catch (\Exception $exception) {
            throw new VehicleTypeListMissing();
        }

        $vehicleTypeArray = array_unique($vehicleTypeArray);

        $vehicleTypeAllowed = ['Passenger', 'LCV', 'Truck'];
        $vehicleTypeAllowedDiff = array_diff($vehicleTypeArray, $vehicleTypeAllowed);

        if (count($vehicleTypeAllowedDiff)) {
            throw new VehicleTypeWrongValue();
        }

        $resourceClass =  self::$listTypeResourceMapping[$list];

        $resource = new $resourceClass();

        $dbVehicleType = $resource->where('company_id', $user->company_id)->where('condition_type', 'new')->pluck('vehicle_type')->toArray();

        $dbVehicleType = array_unique($dbVehicleType);

        $userVpvuArray = $user->vehicle_type;

        if (!$userVpvuArray || !count($userVpvuArray)) {
            throw new UserVehicleTypeMissing();
        }

        $vehicleTypeDiff = array_diff($vehicleTypeArray, $userVpvuArray);

        if (count($vehicleTypeDiff)) {
            throw new VehicleTypeImportMismatchException();
        }

        $vehicleTypesToDelete = array_intersect($dbVehicleType, $userVpvuArray);

        $diff = array_diff($vehicleTypesToDelete, $vehicleTypeArray);

        if (count($diff)) {
            return $diff;
        }

        return false;
    }
}
