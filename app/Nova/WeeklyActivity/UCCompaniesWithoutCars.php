<?php

namespace App\Nova\WeeklyActivity;

use App\Company;
use App\User;

class UCCompaniesWithoutCars extends \Mako\CustomTableCard\CustomTableCard
{
    public function __construct()
    {
        $header = collect(['Company']);

        $this->title('Used car companies without uploads');

        $uploadedCompanyIdArray = User::whereHas('usedCarUploads')->groupBy('company_id')->pluck('company_id')->toArray();

        $uploadedCompanyIdArray = array_filter($uploadedCompanyIdArray);

        $notUploadedCompanyIdArray = User::whereDoesnthave('usedCarUploads')->groupBy('company_id')->pluck('company_id')->toArray();

        $notUploadedCompanyIdArray = array_filter($notUploadedCompanyIdArray);

        $companyIdArray = array_diff($notUploadedCompanyIdArray, $uploadedCompanyIdArray);

        $companyCollection = Company::whereIn('id', $companyIdArray)->get();

        $rootArray = [];

        foreach ($companyCollection as $company) {
            $array = [
                'company' => $company->name,
            ];

            array_push($rootArray, $array);
        }

        $companies = collect($rootArray);

        $this->header($header->map(function($value) {
            return new \Mako\CustomTableCard\Table\Cell($value);
        })->toArray());

        $this->data($companies->map(function($order) {
            return new \Mako\CustomTableCard\Table\Row(
                new \Mako\CustomTableCard\Table\Cell($order['company'])
            );
        })->toArray());
    }
}
