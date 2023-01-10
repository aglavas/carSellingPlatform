<?php

namespace App\Nova;

use App\Imports\StockFCAImport;
use App\Nova\Filters\BrandSelect;
use App\Nova\Filters\CountrySelect;
use App\Nova\Filters\OptionsSelect;
use DigitalCreative\MegaFilter\HasMegaFilterTrait;
use Illuminate\Http\Request;
use Laravel\Nova\Fields\BelongsTo;
use Laravel\Nova\Fields\Country;
use Laravel\Nova\Fields\Date;
use Laravel\Nova\Fields\ID;
use Laravel\Nova\Fields\Text;
use Efdi\UsedCarsFiltering\UsedCarsFiltering;
use App\Nova\Actions\DataExport;
use App\Service\NotificationService;
use App\Nova\Filters\NotificationUpdateFilter;

class StockFCA extends Resource
{
    use HasMegaFilterTrait;

    public static $with = ['brand'];

    /**
     * The model the resource corresponds to.
     *
     * @var string
     */
    public static $model = \App\StockFCA::class;


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
        'brand_id',
        'model_name',
        'version',
        'model_id',
        'equipment',
        'equipment_description',
        'options',
        'options_description',
        'color',
        'color_description',
        'interior',
        'co2',
        'vin',
        'ident'
    ];

    public static function label()
    {
        return 'FCA';
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
            Text::make('Model Name')->readonly(),
            Text::make('Version')->readonly(),
            Text::make('Model Id')->readonly(),
            Text::make('Equipment')->readonly(),
            Text::make('Equipment Description')->readonly(),
            Text::make('Options')->readonly(),
            Text::make('Options Description')->readonly(),
            Text::make('Color')->readonly(),
            Text::make('Color Description')->readonly(),
            Text::make('Interior')->readonly(),
            Text::make('Co2')->readonly(),
            Text::make('Vin')->readonly(),
            Text::make('Ident')->readonly(),
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

        $updates = $notificationService->getNotificationUpdates(StockFCAImport::class);

        return [
            (new UsedCarsFiltering())->withMeta([
                'filters' => $this->filters($request),
                'model' => self::$model,
                'resource' => $request->resource,
                'updates' => (array) $updates,
                'listType' => StockFCAImport::class,
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
            (new CountrySelect('country', \App\StockFCA::class))->withMeta([
                'name' => 'Country',
                'type' => 'string',
                'multiple' => false,
                'range' => false,
                'width' => 'w-1/3'
            ]),
            (new BrandSelect('brand_id', \App\StockFCA::class))->withMeta([
                'name' => 'Brand',
                'type' => 'string',
                'multiple' => false,
                'relation' => true,
                'range' => false,
                'width' => 'w-1/3'
            ]),
            (new OptionsSelect('model_name', \App\StockFCA::class))->withMeta([
                'name' => 'Model name',
                'type' => 'string',
                'multiple' => false,
                'range' => false,
                'width' => 'w-1/3'
            ]),
            (new OptionsSelect('version', \App\StockFCA::class))->withMeta([
                'name' => 'Version',
                'type' => 'string',
                'multiple' => false,
                'range' => false,
                'width' => 'w-1/3'
            ]),
            (new OptionsSelect('model_id', \App\StockFCA::class))->withMeta([
                'name' => 'Model Id',
                'type' => 'string',
                'multiple' => false,
                'range' => false,
                'width' => 'w-1/3'
            ]),
            (new OptionsSelect('color', \App\StockFCA::class))->withMeta([
                'name' => 'Color',
                'type' => 'string',
                'multiple' => false,
                'range' => false,
                'width' => 'w-1/3'
            ]),
            (new OptionsSelect('interior', \App\StockFCA::class))->withMeta([
                'name' => 'Interior',
                'type' => 'string',
                'multiple' => false,
                'range' => false,
                'width' => 'w-1/3'
            ]),
            (new NotificationUpdateFilter('vin', \App\StockFCA::class))->withMeta([
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
            (new DataExport('stock-f-c-as.xlsx', 'fca', new \App\StockFCA()))->canSee(function ($request) {
                return true;
            })->canRun(function ($request) {
                return true;
            })
        ];
    }
}
