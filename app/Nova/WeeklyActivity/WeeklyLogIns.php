<?php

namespace App\Nova\WeeklyActivity;

use App\Imports\StockUsedCentralEuropeImport;
use App\StockListUpload;
use App\User;
use Carbon\Carbon;

class WeeklyLogIns extends \Mako\CustomTableCard\CustomTableCard
{
    /**
     * WeeklyLogIns constructor.
     */
    public function __construct()
    {
        $header = collect(['User', 'Company', 'Country', 'Number of logins']);

        $this->title('Last week log in activity');

        $logInCollection = User::whereHas('logInActivity', function ($query) {
            $lastWeek = \Carbon\Carbon::today()->subDays(7);
            $query->where('created_at', '>=', $lastWeek);
        })->with('company')->withCount('logInActivity')->get();

        $rootArray = [];

        foreach ($logInCollection as $logInItem) {

            $company = $logInItem->company ? $logInItem->company->name : 'N/A';

            try {
                $array = [
                    'user' => $logInItem->email,
                    'company' => $company,
                    'country' => convert_iso3166_to_country($logInItem->country),
                    'log_in_number' => $logInItem->log_in_activity_count,
                ];
            } catch (\Exception $exception) {
                $array = [
                    'user' => $logInItem->email,
                    'company' => $company,
                    'country' => $logInItem->country,
                    'log_in_number' => $logInItem->log_in_activity_count,
                ];
            }

            array_push($rootArray, $array);
        }

        $orders = collect($rootArray);

        $this->header($header->map(function($value) {
            return new \Mako\CustomTableCard\Table\Cell($value);
        })->toArray());

        $this->data($orders->map(function($order) {
            return new \Mako\CustomTableCard\Table\Row(
                new \Mako\CustomTableCard\Table\Cell($order['user']),
                new \Mako\CustomTableCard\Table\Cell($order['company']),
                new \Mako\CustomTableCard\Table\Cell($order['country']),
                new \Mako\CustomTableCard\Table\Cell($order['log_in_number'])
            );
        })->toArray());
    }
}
