<?php

namespace App\Nova\WeeklyActivity;

use App\Imports\StockUsedCentralEuropeImport;
use App\StockListUpload;
use Carbon\Carbon;

class LastUploads extends \Mako\CustomTableCard\CustomTableCard
{
    public function __construct()
    {
        $header = collect(['User', 'Company', 'Country', 'Quantity', 'Date']);

        $this->title('Last 20 of uploads');
        //$this->refresh(5); // If you need refresh your card data (in seconds)
        //$this->viewall(['label' => 'View All', 'link' => '/resources/orders']);

        $uploadCollection = StockListUpload::with('uploader.company', 'log')->where('list_type', '=', StockUsedCentralEuropeImport::class)->orderBy('created_at','desc')->take(20)->get();

        $rootArray = [];

        foreach ($uploadCollection as $upload) {

            try {
                $property = $upload->log->properties;
            } catch (\Exception $exception) {
                $property = null;
            }

            if ($property) {
                $quantity = $property['row_count'];
            } else {
                $quantity = 'N/A';
            }

            $array = [
                'user' => $upload->uploader->name,
                'company' => $upload->uploader->company->name,
                'country' => convert_iso3166_to_country($upload->uploader->country),
                'quantity' => $quantity,
                'date' => Carbon::parse($upload->created_at)->format('Y-m-d H:i:s'),
            ];

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
                new \Mako\CustomTableCard\Table\Cell($order['quantity']),
                new \Mako\CustomTableCard\Table\Cell($order['date'])
            );
        })->toArray());
    }
}
