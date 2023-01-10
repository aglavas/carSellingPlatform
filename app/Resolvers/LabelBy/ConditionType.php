<?php

namespace App\Resolvers\LabelBy;

class ConditionType
{
    /**
     * Resolve gearbox label
     *
     * @param $value
     * @return string
     */
    public static function resolve($value)
    {
        if ($value === 'new') {
            return 'New Vehicles';
        }

        return 'Used Vehicles';
    }
}
