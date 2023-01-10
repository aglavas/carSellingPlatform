<?php

namespace App\Service\CarBidding;

use App\Exceptions\CarBiddingMappingException;
use App\StockVehicle;
use Illuminate\Database\Eloquent\Collection;

class BiddingConverter
{
    /**
     * @var array
     */
    public $countryMapping = [ //albania and montenegro is missing
        'be' => 2,
        'ba' => 3,
        'cz' => 6,
        'sk' => 26,
        'si' => 27,
        'hu' => 31,
        'hr' => 5,
        'rs' => 25,
        'fr' => 10,
        'nl' => 19,
        'de' => 11,
        'pl' => 20,
        'ch' => 30,
    ];

    /**
     * @var array
     */
    public $fuelTypeMapping = [
        'Gasoline' => 3,
        'Diesel' => 4,
        'Hybrid' => 5,
        'Electric' => 6,
        'LPG' => 7,
        'Other Fuels' => 8,
        'Alcohol' => 9,
        'Cryogenic' => 10,
        'Waterstof' => 11,
    ];

    /**
     * @var array
     */
    public $pollutionNormMapping = [
        'EURO0' => 0,
        'EURO1' => 1,
        'EURO2' => 2,
        'EURO3' => 3,
        'EURO4' => 4,
        'EURO5' => 5,
        'EURO6' => 6,
        'EURO5A' => 5,
        'EURO5B' => 5,
        'EURO6A' => 6,
        'EURO6B' => 6,
        'EURO6C' => 6,
        'EURO6D' => 6,
        'EURO6+' => 6,
    ];

    /**
     * @var array
     */
    public $fuelTypeNlMapping = [ //we dont have: PHEV Benzine, PHEV Diesel
        'Gasoline' => 1,
        'Diesel' => 2,
    ];

    /**
     * @var array
     */
    public $vehicleTypeMapping = [ //They don't have Truck so the mapping for Camper is used 73
        'Passenger' => 71,
        'LCV' => 72,
        'Truck' => 73,
    ];

    /**
     * @var array
     */
    public $euCountries = [
        'be',
        'cz',
        'sk',
        'si',
        'hu',
        'hr',
        'fr',
        'nl',
        'de',
        'pl'
    ];

    /**
     * Convert to Bidding API format
     *
     * @param Collection $vehicleCollection
     * @param int $clientId
     * @return array
     */
    public function convert(Collection $vehicleCollection, int $clientId)
    {
        $convertedArray = [];

        try {
            foreach ($vehicleCollection as $key => $vehicle) {
                $data = [
                    'carID' => $vehicle->id,
                    'countryID' => $this->convertCountry($vehicle->country),
                    'clientID' => $clientId,
                    'sellPrice' => (float) $vehicle->b2b_price_ex_vat, //check this
                    'priceType' => 66, //margin
                    'prodDate' => $vehicle->getPropertyForDisplaying('firstregistration'),
                    'carWeight' => $vehicle->weight,
                    'fuelType' => $this->convertFuelType($vehicle->fuel_type),
                    'netherlandsFuel' => $this->convertNlFuelType($vehicle->fuel_type),
                    'importEU' => $this->checkIfEu($vehicle->country),
                    'euroClass' => $this->convertPollutionNorm($vehicle->pollution_norm),
                    'euroClassPaid' => 1,
                    'coc' => $this->convertCoc($vehicle),
                    'co2' => $vehicle->co2,
                    'carType' => $this->convertVehicleType($vehicle->vehicle_type),
                    'co2wltp' => $vehicle->co2,
                    'km' => $vehicle->km,
                    'cm3' => $vehicle->cm3,
                    'newUsed' => $this->convertConditionType($vehicle->condition_type),
                    'engineSize' => $vehicle->cm3,
                    'kwhp' => $vehicle->hp,
                    'inputDate' => $vehicle->created_at->format('Y-m-d'),
                    'carValueNew' => 10000 //Check this!
                ];

                array_push($convertedArray, $data);
            }
        } catch (CarBiddingMappingException $exception) {
            activity('pricing_mapping')
                ->withProperties($exception)
                ->log('Mapping error.');
        }

        return $convertedArray;
    }

    /**
     * Convert country hook
     *
     * @param int $countryId
     * @return string
     */
    public function convertCountryHook(int $countryId)
    {
        $countries = array_flip($this->countryMapping);

        if (!isset($countries[$countryId])) {
            activity('pricing_sync_hook_country_missing')
                ->withProperties($countryId)
                ->log('General sync error.');

            return "Missing. Id: $countryId";


//            throw new CarBiddingMappingException("Missing country with Id $countryId");
        }

        return $countries[$countryId];
    }

    /**
     * Convert country
     *
     * @param string $countryIso
     * @return mixed
     * @throws CarBiddingMappingException
     */
    private function convertCountry(string $countryIso)
    {
        if (!array_key_exists($countryIso, $this->countryMapping)) {
            throw new CarBiddingMappingException("$countryIso code is wrong for country column");
        }

        return $this->countryMapping[$countryIso];
    }

    /**
     * Convert fuel type
     *
     * @param string $fuelType
     * @return mixed
     * @throws CarBiddingMappingException
     */
    private function convertFuelType(string $fuelType)
    {
        if (!array_key_exists($fuelType, $this->fuelTypeMapping)) {
            throw new CarBiddingMappingException("$fuelType code is wrong for fuel_type column");
        }

        return $this->fuelTypeMapping[$fuelType];
    }

    /**
     * Convert Nl fuel type
     *
     * @param string $fuelType
     * @return mixed
     */
    private function convertNlFuelType(string $fuelType)
    {
        if (!array_key_exists($fuelType, $this->fuelTypeNlMapping)) {
            //throw new CarBiddingMappingException("$fuelType code is wrong for fuel_type_nl column");

            activity('pricing_sync_hook_nl_fuel_type_missing')
                ->withProperties($fuelType)
                ->log('General sync error.');

            return $this->fuelTypeNlMapping['Gasoline'];

        }

        return $this->fuelTypeNlMapping[$fuelType];
    }

    /**
     * Convert pollution norm
     *
     * @param string $pollutionNorm
     * @return mixed
     * @throws CarBiddingMappingException
     */
    private function convertPollutionNorm(string $pollutionNorm)
    {
        if (!array_key_exists($pollutionNorm, $this->pollutionNormMapping)) {
            throw new CarBiddingMappingException("$pollutionNorm code is wrong for pollution_norm column");
        }

        return $this->pollutionNormMapping[$pollutionNorm];
    }

    /**
     * Convert pollution norm paid
     *
     * @param $pollutionNormPaid
     * @return int
     */
    private function convertPollutionNormPaid($pollutionNormPaid)
    {
        if ($pollutionNormPaid == 1) {
            return 1;
        }

        return 2;
    }

    /**
     * Convert Coc
     *
     * @param StockVehicle $stockVehicle
     * @return int
     */
    private function convertCoc(StockVehicle $stockVehicle)
    {
        if ($stockVehicle->hasCoc()) {
            return 1;
        }

        return 2;
    }

    /**
     * Convert vehicle type
     *
     * @param string $vehicleType
     * @return mixed
     * @throws CarBiddingMappingException
     */
    private function convertVehicleType(string $vehicleType)
    {
        if (!array_key_exists($vehicleType, $this->vehicleTypeMapping)) {
            throw new CarBiddingMappingException("$vehicleType code is wrong for vehicle_type column");
        }

        return $this->vehicleTypeMapping[$vehicleType];
    }

    /**
     * Convert condition type
     *
     * @param string $conditionType
     * @return int
     */
    private function convertConditionType(string $conditionType)
    {
        if ($conditionType === 'used') {
            return 0;
        }

        return 1;
    }

    /**
     * Check if EU
     *
     * @param string $country
     * @return int
     */
    private function checkIfEu(string $country)
    {
        if (in_array($country, $this->euCountries)) {
            return 1;
        }

        return 2;
    }
}
