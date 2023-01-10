<?php

namespace App\Nova;

use App\Imports\StockCroatiaMBImport;
use App\Imports\StockCroatiaMBVansImport;
use App\Imports\StockCroatiaPSAImport;
use App\Imports\StockCzechPSAImport;
use App\Imports\StockFCAImport;
use App\Imports\StockMercedesImport;
use App\Imports\StockOpelImport;
use App\Imports\StockPeugeotCitroenDsImport;
use App\Imports\StockSlovakiaCitroenImport;
use App\Imports\StockSlovakiaOpelImport;
use App\Imports\StockSlovakiaPeugeotImport;
use App\Imports\StockSloveniaCitroenImport;
use App\Imports\StockSloveniaPeugeotImport;
use App\Imports\StockSwitzerlandImport;
use App\Imports\StockUsedCentralEuropeImport;
use App\StockCroatiaMB;
use Comodolab\Nova\Fields\Help\Help;
use Illuminate\Http\Request;
use Laravel\Nova\Fields\BelongsTo;
use Laravel\Nova\Fields\DateTime;
use Laravel\Nova\Fields\File;
use Laravel\Nova\Fields\ID;
use Laravel\Nova\Fields\Select;
use Laravel\Nova\Fields\Text;
use Laravel\Nova\Http\Requests\NovaRequest;

class StockListUpload extends Resource
{
    /**
     * The model the resource corresponds to.
     *
     * @var string
     */
    public static $model = \App\StockListUpload::class;

    public static $group = '03 Stock List Upload';

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
     * @param \Illuminate\Http\Request $request
     * @return array
     */
    public function fields(Request $request)
    {
        return [
            Help::warning('Hint')->message('Always upload your complete list; not just changes since last upload – reason is that old data will be overwritten for your company. For Used Vehicles please upload the filled out template. <a href="/template-file.xlsx">Download Template</a>')->displayAsHtml()->onlyOnForms(),
            Help::danger('Error', 'Some cars have not been uploaded, please check the status field below.')->onlyOnDetail()->showOnDetail(function() {
               return $this->status != '1';
            }),
            ID::make()->sortable(),
            File::make('File', 'file_path')->creationRules('required')
                ->updateRules(function (NovaRequest $request) {
                    $model = $request->findModelOrFail();
                    return $model->file ? [] : ['required'];
                }),
            DateTime::make('Uploaded', 'created_at')->readonly()->onlyOnIndex(),
            Select::make('List Type')->options(
                [
                    StockFCAImport::class => 'Wholesale FCA',
                    StockMercedesImport::class => 'Wholesale Mercedes',
                    StockOpelImport::class => 'Wholesale Opel',
                    StockPeugeotCitroenDsImport::class => 'Wholesale Peugeot, Citroen, DS',
                    StockSwitzerlandImport::class => 'Wholesale Switzerland',
                    StockUsedCentralEuropeImport::class => 'Used Cars',
                ]
            )->default(StockUsedCentralEuropeImport::class)->canSee(function ($request) {
                return $request->user()->hasRole('Administrator');
            }),
            Select::make('List Type')->options(
                [
                    StockFCAImport::class => 'Wholesale FCA',
                    StockMercedesImport::class => 'Wholesale Mercedes',
                    StockOpelImport::class => 'Wholesale Opel',
                    StockPeugeotCitroenDsImport::class => 'Wholesale Peugeot, Citroen, DS',
                    StockSwitzerlandImport::class => 'Wholesale Switzerland',
                    /*
                    StockSloveniaCitroenImport::class => 'Slovenia Citroen Import',
                    StockSloveniaPeugeotImport::class => 'Slovenia Peugeot Import',
                    StockSlovakiaCitroenImport::class => 'Slovakia Citroen Import',
                    StockSlovakiaPeugeotImport::class => 'Slovakia Peugeot Import',
                    StockSlovakiaOpelImport::class => 'Slovakia Opel Import',
                    StockCzechPSAImport::class => 'Czech PSA Import',
                    StockCroatiaMBImport::class => 'Croatia MB Import',
                    StockCroatiaMBVansImport::class => 'Croatia MB Vans Import',
                    //StockCroatiaPSAImport::class => 'Croatia PSA Import',
                    */
                ]
            )->canSee(function ($request) {
                return $request->user()->stock_type == 'NC' && !$request->user()->hasRole('Administrator');
            }),
            Select::make('List Type')->options(
                [
                    StockUsedCentralEuropeImport::class => 'Used Cars',
                ]
            )->default(StockUsedCentralEuropeImport::class)->canSee(function ($request) {
                return $request->user()->stock_type == 'UC' && !$request->user()->hasRole('Administrator');
            }),
            Text::make('Status')->nullable()->readonly()->asHtml()->hideFromIndex(),
            Text::make('Successful?', function() {
                return ($this->status != '1') ? '❌' : '✔️';
            })->onlyOnIndex(),
            BelongsTo::make('Uploader', 'uploader', User::class)->onlyOnIndex(),
            Text::make('Country', function() {
                return optional($this->uploader)->country;
            })
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
        return [];
    }

    /**
     * Get the filters available for the resource.
     *
     * @param \Illuminate\Http\Request $request
     * @return array
     */
    public function filters(Request $request)
    {
        return [];
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
        return [];
    }

    public static function label()
    {
        return 'Used Car Upload';
    }
}
