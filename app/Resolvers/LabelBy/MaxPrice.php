<?php

namespace App\Resolvers\LabelBy;

class MaxPrice
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

        return "max price € $formattedValue";
    }
}
