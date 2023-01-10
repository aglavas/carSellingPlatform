<?php

namespace App\Imports;

use App\Imports\Processing\StockVehicleProcessing;
use App\Service\DataNormalizer;
use App\Service\ExchangeService;
use App\Service\ExchangeValidationService;
use App\Service\ImportValidationService;
use App\StockUsedCentralEurope;
use App\StockVehicle;
use App\Traits\UserImportData;
use Maatwebsite\Excel\Concerns\Importable;
use Maatwebsite\Excel\Concerns\RegistersEventListeners;
use Maatwebsite\Excel\Concerns\SkipsErrors;
use Maatwebsite\Excel\Concerns\SkipsFailures;
use Maatwebsite\Excel\Concerns\SkipsOnError;
use Maatwebsite\Excel\Concerns\SkipsOnFailure;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithEvents;
use Maatwebsite\Excel\Concerns\WithHeadingRow;
use Maatwebsite\Excel\Concerns\WithMultipleSheets;
use Maatwebsite\Excel\Concerns\WithValidation;
use Maatwebsite\Excel\Events\BeforeImport;

class StockVehicleImport implements ToModel, WithHeadingRow, WithEvents, WithValidation, SkipsOnError, SkipsOnFailure, WithMultipleSheets
{
    use Importable, RegistersEventListeners, SkipsFailures, SkipsErrors, UserImportData;

    /**
     * @var ExchangeValidationService
     */
    private static $exchangeValidationService;

    /**
     * Before import
     *
     * @param BeforeImport $event
     * @throws \Exception
     */
    public static function beforeImport(BeforeImport $event)
    {
        $country = strtolower(auth()->user()->country);

        list($vehicleTypeArray, $stockType, $brandArray) = self::getUserImportData();

        if ($stockType === 'UC') {
            StockVehicle::where('country', 'ilike', $country)
                ->where('company', auth()->user()->company->name)
                ->where('condition_type', 'used')
                ->delete();
        } elseif ($stockType === 'NC') {
            StockVehicle::where('country', 'ilike', $country)
                ->where('company', auth()->user()->company->name)
                ->where('condition_type', 'new')
                ->whereIn('vehicle_type', $vehicleTypeArray)
                ->whereIn('brand', $brandArray)
                ->delete();
        } elseif ($stockType === 'both') {
            StockVehicle::where('country', 'ilike', $country)
                ->where('company', auth()->user()->company->name)
                ->where('condition_type', 'used')
                ->delete();

            StockVehicle::where('country', 'ilike', $country)
                ->where('company', auth()->user()->company->name)
                ->where('condition_type', 'new')
                ->whereIn('vehicle_type', $vehicleTypeArray)
                ->whereIn('brand', $brandArray)
                ->delete();
        } else {
            throw new \Exception("Impossible case.");
        }

        self::$exchangeValidationService = new ExchangeValidationService();
    }

    /**
     * Return created model
     *
     * @param array $row
     * @return StockVehicle|\Illuminate\Database\Eloquent\Model|\Illuminate\Database\Eloquent\Model[]|null
     * @throws \App\Exceptions\ImportColumnMissingException
     */
    public function model(array $row)
    {
        $exchangeService = new ExchangeService();

        $processor = new StockVehicleProcessing($exchangeService);

        $params = $processor->process($row);

        return new StockVehicle($params);
    }

    /**
     * Prepare row for validation
     *
     * @param $data
     * @param $index
     * @return array|mixed
     * @throws \Exception
     */
    public function prepareForValidation($data, $index)
    {
        $data = DataNormalizer::normalize($data);

        return $data;
    }

    /**
     * Validation rules
     *
     * @return array
     */
    public function rules(): array
    {
        $importValidation = new ImportValidationService(self::$exchangeValidationService);

        $rules = $importValidation->getRules();

        return $rules;
    }

    public function sheets(): array
    {
        return [
            0 => $this
        ];
    }
}
