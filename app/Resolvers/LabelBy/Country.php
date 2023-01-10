<?php

namespace App\Resolvers\LabelBy;


use App\User;

class Country {
    public static function resolve($country) {
        return convert_iso3166_to_country($country);
    }
}
