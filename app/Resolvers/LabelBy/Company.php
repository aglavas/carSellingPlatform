<?php

namespace App\Resolvers\LabelBy;

use App\Company as CompanyModel;

class Company {
    public static function resolve($companyId) {
        return CompanyModel::find($companyId)->name;
    }
}
