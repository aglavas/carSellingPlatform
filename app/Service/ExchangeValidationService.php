<?php

namespace App\Service;

class ExchangeValidationService
{
    /**
     * @var array
     */
    private $rateSymbols;

    /**
     * ExchangeValidationService constructor.
     * @throws \Exception
     */
    public function __construct()
    {
        $apiKey = config('swap.services.fixer.access_key');

        try {
            $this->rateSymbols = json_decode(file_get_contents("http://data.fixer.io/api/symbols?access_key={$apiKey}"), true)['symbols'];
        } catch (\Exception $exception) {
//            throw new \Exception('Fixer is not responding');
        }
    }

    /**
     * Validate currency code
     *
     * @param string $currencyCode
     * @return bool
     * @throws \Exception
     */
    public function validateCurrencyCode(string $currencyCode)
    {
        if (isset($this->rateSymbols[$currencyCode])) {
            return true;
        }
        throw new \Exception('Currency code is not supported');
    }
}
