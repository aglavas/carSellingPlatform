<?php

namespace App\Resolvers\LabelBy;

class TransactionCountry {
    public static function resolve($country) {
        $country = strtolower($country);
        return convert_iso3166_to_country($country);
    }
}
