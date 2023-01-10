<?php

namespace App\Nova;

use App\Nova\Actions\GenerateUserDataReport;
use Illuminate\Http\Request;
use Laravel\Nova\Fields\ID;
use Laravel\Nova\Fields\Text;
use Laravel\Nova\Fields\Code;
use App\DataIntegrityReport as DataIntegrityReportModel;

class DataIntegrityReport extends Resource
{
    /**
     * The model the resource corresponds to.
     *
     * @var string
     */
    public static $model = DataIntegrityReportModel::class;

    /**
     * The single value that should be used to represent the resource when being displayed.
     *
     * @var string
     */
    public static $title = 'id';

    /**
     * The columns that should be searched.
     *
     * @var array
     */
    public static $search = [
        'id',
    ];

    /**
     * Get the fields displayed by the resource.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function fields(Request $request)
    {
        return [
            ID::make(__('ID'), 'id')->sortable(),
            Text::make(__('Report Type'), 'type', function () {
                if ($this->type === DataIntegrityReportModel::COMPANY_WITHOUT_SELLER_ROLE_COMBINATION) {
                    return 'Company does not Uploader-Logistics combination. One of roles is missing';
                } elseif ($this->type === DataIntegrityReportModel::COMPANY_WITHOUT_LOGISTICS_UPLOADER_ROLE) {
                    return 'Company does not have Uploader and Logistics roles. Both are missing';
                } elseif ($this->type === DataIntegrityReportModel::COMPANY_WITHOUT_USERS) {
                    return 'Company does not have any users';
                } elseif ($this->type === DataIntegrityReportModel::USER_WITHOUT_COMPANY) {
                    return 'User does not have any company';
                } elseif ($this->type === DataIntegrityReportModel::USER_WITHOUT_VEHICLE_TYPE) {
                    return 'User does not have vehicle type set';
                } elseif ($this->type === DataIntegrityReportModel::USER_WITHOUT_STOCK_TYPE) {
                    return 'User does not have a stock type set';
                } elseif ($this->type === DataIntegrityReportModel::NC_USER_WITHOUT_BRAND) {
                    return 'User is either New Cars seller or "both" seller, but it does not have any brands attached';
                } else {
                    return $this->type;
                }
            }),
            Code::make('Report', 'report_data', function () {
                $reportDataArray = $this->report_data;

                $reportText = '';

                foreach ($reportDataArray as $reportData) {
                    if (isset($reportData['company_id'])) {
                        $companyId = $reportData['company_id'];
                        $companyName = $reportData['company_name'];
                        $report = $reportData['report'];

                        $reportText .= "
                        ----------------
                        ----------------
                        Comapny Id: $companyId
                        Comapny Name: $companyName
                        Report: $report
                        ----------------
                        ----------------
                        ";
                    } elseif (isset($reportData['user_id'])) {
                        $userId = $reportData['user_id'];
                        $userName = $reportData['user_name'];
                        $report = $reportData['report'];

                        $reportText .= "
                        ----------------
                        ----------------
                        User Id: $userId
                        User Name: $userName
                        Report: $report
                        ----------------
                        ----------------
                        ";
                    }
                }

                return $reportText;
            })->onlyOnDetail(),
            Text::make(__('Time'), 'created_at', function () {
                return $this->created_at->format('Y-m-d H:i:s');
            }),
        ];
    }

    /**
     * Get the cards available for the request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function cards(Request $request)
    {
        return [];
    }

    /**
     * Get the filters available for the resource.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function filters(Request $request)
    {
        return [];
    }

    /**
     * Get the lenses available for the resource.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function lenses(Request $request)
    {
        return [];
    }

    /**
     * Get the actions available for the resource.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function actions(Request $request)
    {
        return [
            //new GenerateUserDataReport()
        ];
    }
}
