<?php

namespace App\Nova;

use App\Nova\Metrics\NewCars;
use App\Nova\Metrics\NewCarsDownload;
use App\Nova\Metrics\StockFCAByCountry;
use App\Nova\Metrics\StockMercedesByCountry;
use App\Nova\Metrics\StockOpelByCountry;
use App\Nova\Metrics\StockPeugeotCitroenDsByCountry;
use App\Nova\Metrics\TotalCars;
use App\Nova\Metrics\UsedByBrand;
use App\Nova\Metrics\UsedByCountry;
use App\Nova\Metrics\UsedCars;
use App\Nova\Metrics\UsedCarsDownload;
use Illuminate\Http\Request;

class Analytics extends Resource
{
    /**
     * The model the resource corresponds to.
     *
     * @var string
     */
    public static $model = \App\Analytics::class;

    public static $group = '04 Analytics';

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

    public function __construct($resource)
    {
        $this->resource = $resource;
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
            //ID::make()->sortable(),
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
        return [
            new StockPeugeotCitroenDsByCountry(),
            new StockMercedesByCountry(),
            new StockOpelByCountry(),
            new StockFCAByCountry(),
            new UsedByBrand(),
            new UsedByCountry(),
            new UsedCars(),
            new NewCars(),
            new TotalCars(),
            new UsedCarsDownload(),
            new NewCarsDownload()
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
}
