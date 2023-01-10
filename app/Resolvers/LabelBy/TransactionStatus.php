<?php

namespace App\Resolvers\LabelBy;

class TransactionStatus {
    public static function resolve($value) {
        return __('carmarket.transaction_status.'.$value);
    }
}
