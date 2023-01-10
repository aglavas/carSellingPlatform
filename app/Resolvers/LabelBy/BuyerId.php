<?php

namespace App\Resolvers\LabelBy;


use App\User;

class BuyerId {
    public static function resolve($buyerId) {
        return User::find($buyerId)->company->name;
    }
}
