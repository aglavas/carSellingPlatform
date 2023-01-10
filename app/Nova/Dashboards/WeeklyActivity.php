<?php

namespace App\Nova\Dashboards;

use App\Nova\Metrics\OtherCarUploads;
use App\Nova\WeeklyActivity\UCCompaniesWithoutCars;
use Laravel\Nova\Dashboard;
use App\Nova\Metrics\UsedCarUploads;
use App\Nova\WeeklyActivity\LastUploads;
use App\Nova\WeeklyActivity\WeeklyLogIns;

class WeeklyActivity extends Dashboard
{
    /**
     * Get the cards for the dashboard.
     *
     * @return array
     */
    public function cards()
    {
        return [
            new LastUploads(),
            new UsedCarUploads(),
            new OtherCarUploads(),
            new WeeklyLogIns(),
            new UCCompaniesWithoutCars()
        ];
    }

    /**
     * Get the displayable name of the dashboard.
     *
     * @return string
     */
    public static function label()
    {
        return 'Weekly activity';
    }


    /**
     * Get the URI key for the dashboard.
     *
     * @return string
     */
    public static function uriKey()
    {
        return 'weekly-activity';
    }
}
