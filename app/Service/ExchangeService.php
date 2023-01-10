<?php

namespace App\Service;

use Swap\Laravel\Facades\Swap;

class ExchangeService
{
    /**
     * Convert euro to currency
     *
     * @param $value
     * @param string $currency
     * @return float|int
     */
    public function convertEuroToCurrency($value, string $currency)
    {
        $exchangeRate = Swap::latest("EUR/{$currency}");

        $rateValue = $exchangeRate->getValue();

        $converted = $value / $rateValue;

        return $converted;
    }
}
