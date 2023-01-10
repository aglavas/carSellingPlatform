<?php

namespace App\Nova;

use App\Imports\StockMercedesImport;
use App\Nova\Filters\BrandSelect;
use App\Nova\Filters\CountrySelect;
use App\Nova\Filters\OptionsSelect;
use DigitalCreative\MegaFilter\HasMegaFilterTrait;
use Efdi\UsedCarsFiltering\UsedCarsFiltering;
use Illuminate\Http\Request;
use Laravel\Nova\Fields\BelongsTo;
use Laravel\Nova\Fields\Country;
use Laravel\Nova\Fields\Date;
use Laravel\Nova\Fields\ID;
use Laravel\Nova\Fields\Text;
use philperusse\NovaTooltipField\Tooltip;
use App\Nova\Actions\DataExport;
use App\Service\NotificationService;
use App\Nova\Filters\NotificationUpdateFilter;

class StockMercedes extends Resource
{
    use HasMegaFilterTrait;

    public static $with = ['brand'];

    /**
     * The model the resource corresponds to.
     *
     * @var string
     */
    public static $model = \App\StockMercedes::class;

    public static $group = '01 New Stock';

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
        'country',
        'an',
        'bm',
        'color',
        'interior',
        'upholstery',
        'options',
        'vin'
    ];

    public static function label()
    {
        return 'Mercedes-Benz';
    }

    /**
     * Get the fields displayed by the resource.
     *
     * @param \Illuminate\Http\Request $request
     * @return array
     */
    public function fields(Request $request)
    {
        return [
            ID::make()->sortable()->hideFromIndex(),
            Country::make('Country')->readonly(),
            BelongsTo::make('Brand')->viewable(false),
            Text::make('Model', 'model')->readonly(),
            Text::make('Man. Order Nr.', 'an')->readonly(),
            Text::make('Version Code', 'bm')->readonly(),
            Text::make('Color')->readonly(),
            Text::make('Interior')->readonly(),
            Text::make('Upholstery')->readonly(),
            Tooltip::make('Options Info', function() {
                return $this->options;
            }),
            Text::make('Vin')->readonly(),
            Text::make('Contacts', function () {
                $users = get_contacts_of_new_car($this->country, $this->brand->id);
                return view('nova-resources.detail-contacts', ['users' => $users])->render();
            })->asHtml()->onlyOnDetail(),
            Text::make('Contact1', function() {
                $contact = get_contacts_of_new_car($this->country, $this->brand_id)->values()->get(0);
                if ($contact) {
                    return $contact->email . ', ' . $contact->function_description . ', Tel: ' . $contact->telephone . ', Mob: ' . $contact->mobile;
                }
                return '';
            })->onlyOnExport(),
            Text::make('Contact2', function() {
                $contact = get_contacts_of_new_car($this->country, $this->brand_id)->values()->get(1);
                if ($contact) {
                    return $contact->email . ', ' . $contact->function_description . ', Tel: ' . $contact->telephone . ', Mob: ' . $contact->mobile;
                }
                return '';
            })->onlyOnExport(),
            Text::make('Contact3', function() {
                $contact = get_contacts_of_new_car($this->country, $this->brand_id)->values()->get(2);
                if ($contact) {
                    return $contact->email . ', ' . $contact->function_description . ', Tel: ' . $contact->telephone . ', Mob: ' . $contact->mobile;
                }
                return '';
            })->onlyOnExport()
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

        $updates = $notificationService->getNotificationUpdates(StockMercedesImport::class);

        return [
            (new UsedCarsFiltering())->withMeta([
                'filters' => $this->filters($request),
                'model' => self::$model,
                'resource' => $request->resource,
                'updates' => (array) $updates,
                'listType' => StockMercedesImport::class,
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
            (new CountrySelect('country', \App\StockMercedes::class))->withMeta([
                'name' => 'Country',
                'type' => 'string',
                'multiple' => false,
                'range' => false,
                'width' => 'w-1/3'
            ]),
            (new OptionsSelect('an', \App\StockMercedes::class))->withMeta([
                'name' => 'Version code',
                'type' => 'string',
                'multiple' => false,
                'range' => false,
                'width' => 'w-1/3'
            ]),
            (new OptionsSelect('bm', \App\StockMercedes::class))->withMeta([
                'name' => 'Man. Order Nr.',
                'type' => 'string',
                'multiple' => false,
                'range' => false,
                'width' => 'w-1/3'
            ]),
            (new OptionsSelect('color', \App\StockMercedes::class))->withMeta([
                'name' => 'Color',
                'type' => 'string',
                'multiple' => false,
                'range' => false,
                'width' => 'w-1/3'
            ]),
            (new OptionsSelect('interior', \App\StockMercedes::class))->withMeta([
                'name' => 'Interior',
                'type' => 'string',
                'multiple' => false,
                'range' => false,
                'width' => 'w-1/3'
            ]),
            (new OptionsSelect('upholstery', \App\StockMercedes::class))->withMeta([
                'name' => 'Upholstery',
                'type' => 'string',
                'multiple' => false,
                'range' => false,
                'width' => 'w-1/3'
            ]),
            (new BrandSelect('brand_id', \App\StockMercedes::class))->withMeta([
                'name' => 'Brand',
                'type' => 'string',
                'multiple' => false,
                'relation' => true,
                'range' => false,
                'width' => 'w-1/3'
            ]),
            (new NotificationUpdateFilter('vin', \App\StockMercedes::class))->withMeta([
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
            (new DataExport('stock-mercedes.xlsx', 'mercedes', new \App\StockMercedes()))->canSee(function ($request) {
                return true;
            })->canRun(function ($request) {
                return true;
            })
        ];
    }
}
