<?php

namespace App\Nova;

use App\Imports\StockUsedCentralEuropeImport;
use App\Nova\Actions\DataExport;
use App\Nova\Filters\CountrySelect;
use App\Nova\Filters\NotificationUpdateFilter;
use App\Nova\Filters\OptionsSelect;
use Efdi\UsedCarsFiltering\UsedCarsFiltering;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Laravel\Nova\Fields\Date;
use Laravel\Nova\Fields\ID;
use Laravel\Nova\Fields\Text;
use philperusse\NovaTooltipField\Tooltip;
use App\Service\NotificationService;
use Laravel\Nova\Fields\Boolean;

class StockUsedCentralEurope extends Resource
{

    /**
     * The model the resource corresponds to.
     *
     * @var string
     */
    public static $model = \App\StockUsedCentralEurope::class;

    public static $group = '02 Used Stock';

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
        'vin',
        'origin',
        'brand',
        'vpvu',
        'model',
        'version',
        'engine',
        'fuel_type',
        'gearbox',
        'km',
        'firstregistration',
        'color_code',
        'color_description',
        'options_code',
        'option_code_description',
        'option_code_description_english',
        'co2',
        'b2b_price_ex_vat',
        'vat_deductible',
        'disponibility',
        'loading_place',
        'note',
        'language_option_code_description',
        'currency_iso_codification',
        'url_address',
        'country',
        'company',
    ];

    public static function label()
    {
        return 'Used Car List';
    }

    /**
     * Get the fields displayed by the resource.
     *
     * @param \Illuminate\Http\Request $request
     * @return array
     */
    public function fields(Request $request)
    {
        $notificationService = NotificationService::getInstance();

        $updatedVinArray = $notificationService->getNotificationUpdates(StockUsedCentralEuropeImport::class);

        return [
            ID::make()->sortable()->hideFromIndex(),
            Text::make('Updated')->displayUsing(function () use ($updatedVinArray, $notificationService) {
                $result = $notificationService->checkIfUpdated($updatedVinArray, $this->vin);

                if ($result) {
                    return  '✅';
                }
            }),
            Text::make('Vin')->nullable(),
            Text::make('Brand')->nullable(),
            Text::make('Model')->nullable(),
            Text::make('Version')->nullable(),
            Text::make('Engine')->nullable(),
            Text::make('Fuel Type')->nullable(),
            Text::make('Gearbox')->nullable(),
            Text::make('Km')->nullable()->sortable()->displayUsing(function ($value) {
                if (request()->input('action') == 'download-excel') {
                    return $value;
                }
                return number_format(intval($value), 0, ",", ".");
            }),
            Date::make('First Registration', 'firstregistration')->nullable()->onlyOnDetail(),
            Date::make('First Registration Year', function () {
                return is_null($this->firstregistration) ? '' : $this->firstregistration->format('Y');
            }),
            Text::make('Color Code')->nullable(),
            Text::make('Color Description')->nullable(),
            Tooltip::make('Options Code', function () {
                return $this->options_code;
            }),
            Text::make('Options Code')->hideFromIndex()->nullable(),
            Tooltip::make('Options Info', function () {
                return $this->option_code_description;
            }),
            Text::make('Option Code Description')->hideFromIndex()->nullable(),
            Tooltip::make('Options Info EN', function () {
                return $this->option_code_description_english;
            }),
            Text::make('Option Code Description English')->hideFromIndex()->nullable(),
            Text::make('Currency', 'currency_iso_codification')->nullable(),
            Text::make('B2b Price Ex Vat')->nullable()->sortable()->displayUsing(function ($value) {
                if (request()->input('action') == 'download-excel') {
                    return $value;
                }
                return number_format($value, 2, ",", ".");
            }),
            Text::make('Price in Euro (Approx.)', 'price_in_euro')->displayUsing(function ($value) {
                if (request()->input('action') == 'download-excel') {
                    return $value;
                }
                return is_null($value) ? '' : number_format($value, 2, ",", ".");
            })->sortable(),
            Text::make('Vat Deductible')->nullable(),
            Text::make('Damages Excl Vat')->nullable()->displayUsing(function ($value) {
                return is_null($value) ? '' : '€ ' . $value;
            }),
            Text::make('VpVu')->nullable(),
            Text::make('Origin')->nullable(),
            Date::make('Disponibility', function () {
                return is_null($this->disponibility) ? '️✔️' : $this->disponibility->format('Y-m-d');
            })->nullable(),
            Text::make('Loading Place')->nullable(),
            Text::make('Note')->nullable(),
            Text::make('Co2')->nullable(),
            Text::make('Language', 'language_option_code_description')->nullable()->onlyOnDetail(),
            Text::make('Url Address', function () {
                if ($this->url_address) {
                    $url = Str::of($this->url_address)
                        ->replace('https://', '')
                        ->replace('http://', '')
                        ->prepend('https://translate.google.com/translate?hl=&sl=auto&tl=en&u=');
                    return '<a href="' . $url . '" target="_blank">Link</a>';
                }
                return '';
            })->nullable()->asHtml(),
            Text::make('Url', function () {
                if ($this->url_address) {
                    return '=HYPERLINK("' . Str::of($this->url_address)
                            ->replace('https://', '')
                            ->replace('http://', '')
                            ->prepend('https://translate.google.com/translate?hl=&sl=auto&tl=en&u=') . '")';
                }
                return '';
            })->nullable()->onlyOnExport(),
            Text::make('Country')->nullable(),
            Text::make('Company')->nullable(),
            Text::make('Exchange Rate', function() {
                if ($this->price_in_euro > 0) {
                    return round($this->b2b_price_ex_vat / $this->price_in_euro, 2);
                }
                return '';
            }),
            Text::make('Contacts', function () {
                $company = $this->company;
                $users = \App\User::role('Logistics')
                    ->where('country', 'ilike', strtoupper($this->country) ?? '')
                    ->where('stock_type', 'UC')
                    ->orWhere('show_contact_on_all_cars', true)
                    ->orderBy('name', 'ASC')
                    ->get()
                    ->filter(function($item) use ($company) {
                        return $item->company->name === $company || $item->show_contact_on_all_cars;
                    })
                    ->sortBy('show_contact_on_all_cars');
                return view('nova-resources.detail-contacts', ['users' => $users])->render();
            })->onlyOnDetail()->asHtml(),
        ];
    }

    /**
     * Get the cards available for the request.
     *
     * @param \Illuminate\Http\Request $request
     * @return array
     */
    public function cards(Request $request)
    {
        $notificationService = NotificationService::getInstance();

        $updates = $notificationService->getNotificationUpdates(StockUsedCentralEuropeImport::class);

        return [
            (new UsedCarsFiltering())->withMeta([
                'filters' => $this->filters($request),
                'model' => self::$model,
                'resource' => $request->resource,
                'updates' => $updates,
                'listType' => StockUsedCentralEuropeImport::class,
            ])
        ];
    }

    /**
     * Get the filters available for the resource.
     *
     * @param \Illuminate\Http\Request $request
     * @return array
     */
    public function filters(Request $request)
    {
        return [
            (new OptionsSelect('brand', \App\StockUsedCentralEurope::class))->withMeta([
                'name' => 'Brand',
                'type' => 'string',
                'multiple' => true,
                'range' => false,
                'width' => 'w-1/3'
            ]),
            (new OptionsSelect('vpvu', \App\StockUsedCentralEurope::class))->withMeta([
                'name' => 'Passenger/LCV',
                'type' => 'string',
                'multiple' => false,
                'range' => false,
                'width' => 'w-1/3'
            ]),
            (new OptionsSelect('km', \App\StockUsedCentralEurope::class))->withMeta([
                'name' => 'Km',
                'type' => 'range',
                'multiple' => false,
                'range' => true,
                'width' => 'w-1/3'
            ]),
            (new OptionsSelect('model', \App\StockUsedCentralEurope::class))->withMeta([
                'name' => 'Model',
                'type' => 'string',
                'multiple' => false,
                'range' => false,
                'width' => 'w-1/3'
            ]),

            (new OptionsSelect('version', \App\StockUsedCentralEurope::class))->withMeta([
                'name' => 'Version',
                'type' => 'string',
                'multiple' => false,
                'range' => false,
                'width' => 'w-1/3'
            ]),
            (new OptionsSelect('price_in_euro', \App\StockUsedCentralEurope::class))->withMeta([
                'name' => 'Price in Euro (Approx.)',
                'type' => 'range',
                'multiple' => false,
                'range' => true,
                'width' => 'w-1/3'
            ]),
            (new OptionsSelect('fuel_type', \App\StockUsedCentralEurope::class))->withMeta([
                'name' => 'Fuel Type',
                'type' => 'string',
                'multiple' => false,
                'range' => false,
                'width' => 'w-1/3'
            ]),
            (new OptionsSelect('gearbox', \App\StockUsedCentralEurope::class))->withMeta([
                'name' => 'Gearbox',
                'type' => 'string',
                'multiple' => false,
                'range' => false,
                'width' => 'w-1/3'
            ]),
            (new OptionsSelect('firstregistration', \App\StockUsedCentralEurope::class))->withMeta([
                'name' => 'FirstRegistration',
                'type' => 'date-range',
                'multiple' => false,
                'range' => true,
                'width' => 'w-1/3'
            ]),
            (new CountrySelect('country', \App\StockUsedCentralEurope::class))->withMeta([
                'name' => 'Country',
                'type' => 'string',
                'multiple' => false,
                'range' => false,
                'width' => 'w-1/3'
            ]),
            (new NotificationUpdateFilter('vin', \App\StockUsedCentralEurope::class))->withMeta([
                'name' => 'Updated vin',
                'type' => 'string',
                'multiple' => 'NAN',
                'notification' => true,
                'range' => false,
                'width' => 'w-full'
            ])
        ];
    }

    /**
     * Get the lenses available for the resource.
     *
     * @param \Illuminate\Http\Request $request
     * @return array
     */
    public function lenses(Request $request)
    {
        return [];
    }

    /**
     * Get the actions available for the resource.
     *
     * @param \Illuminate\Http\Request $request
     * @return array
     */
    public function actions(Request $request)
    {
        return [
            (new DataExport('stock-used-central-europes.xlsx', 'used', new \App\StockUsedCentralEurope()))->canSee(function ($request) {
                return true;
            })->canRun(function ($request) {
                return true;
            })
        ];
    }
}
