<?php

namespace App\Resolvers\LabelBy;

class Gearbox
{
    /**
     * Resolve gearbox label
     *
     * @param $value
     * @return string
     */
    public static function resolve($value)
    {
        if ($value === 'A') {
            return 'Automatic';
        }

        return 'Manual';
    }
}
