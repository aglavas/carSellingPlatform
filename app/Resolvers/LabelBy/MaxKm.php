<?php

namespace App\Resolvers\LabelBy;

class MaxKm
{
    /**
     * Resolve gearbox label
     *
     * @param $value
     * @return string
     */
    public static function resolve($value)
    {
        $formattedValue = carmarket_price_format($value);

        return "max KM $formattedValue";
    }
}
