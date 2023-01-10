<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class DataIntegrityReport extends Model
{
    const COMPANY_WITHOUT_SELLER_ROLE_COMBINATION = 'company_without_seller_role_combination';
    const COMPANY_WITHOUT_LOGISTICS_UPLOADER_ROLE = 'company_without_logistics_uploader';
    const COMPANY_WITHOUT_USERS = 'company_without_users';
    const USER_WITHOUT_COMPANY = 'user_without_company';
    const USER_WITHOUT_VEHICLE_TYPE = 'user_without_vehicle_type';
    const USER_WITHOUT_STOCK_TYPE = 'user_without_stock_type';
    const NC_USER_WITHOUT_BRAND = 'nc_user_without_brand';

    /**
     * @var string
     */
    protected $table = 'data_integrity_reports';

    /**
     * @var array
     */
    protected $guarded = ['id'];

    /**
     * @var array
     */
    protected $casts = [
        'report_data' => 'json'
    ];
}
