<?php

namespace App\Nova;

use App\ActivityLog;
use App\Nova\Actions\InviteUser;
use App\Nova\Filters\CompanyFilter;
use App\Nova\Filters\LoggedInFilter;
use App\Nova\Filters\RoleFilter;
use App\Nova\Filters\StaticOptionsSelect;
use Illuminate\Http\Request;
use Laravel\Nova\Fields\Avatar;
use Laravel\Nova\Fields\BelongsTo;
use Laravel\Nova\Fields\BelongsToMany;
use Laravel\Nova\Fields\Country;
use Laravel\Nova\Fields\ID;
use Laravel\Nova\Fields\MorphToMany;
use Laravel\Nova\Fields\Password;
use Laravel\Nova\Fields\Select;
use Laravel\Nova\Fields\Text;
use Laravel\Nova\Http\Requests\NovaRequest;
use Maatwebsite\LaravelNovaExcel\Actions\DownloadExcel;
use OptimistDigital\MultiselectField\Multiselect;

class User extends Resource
{
    /**
     * The model the resource corresponds to.
     *
     * @var string
     */
    public static $model = \App\User::class;

    public static $group = 'Administration';

    public static $perPageOptions = [25, 50, 100, 150, 200, 500];

    /**
     * The single value that should be used to represent the resource when being displayed.
     *
     * @var string
     */
    public static $title = 'name';

    /**
     * The columns that should be searched.
     *
     * @var array
     */
    public static $search = [
        'id',
        'name',
        'email',
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
            ID::make()->sortable(),

            Avatar::make('Avatar')->maxWidth(50)->disk('public'),

            Text::make('Name')
                ->sortable()
                ->rules('required', 'max:255'),

            Text::make('Email')
                ->sortable()
                ->rules('required', 'email', 'max:254')
                ->creationRules('unique:users,email')
                ->updateRules('unique:users,email,{{resourceId}}'),

            Password::make('Password')
                ->onlyOnForms()
                ->creationRules('required', 'string', 'min:8')
                ->updateRules('nullable', 'string', 'min:8'),
            Country::make('Country')->readonly(function($request) {
                return !$request->user()->hasRole('Administrator');
            })->rules('required'),
            BelongsTo::make('Company')->nullable()->readonly(function($request) {
                return !$request->user()->hasRole('Administrator');
            })->rules('required'),
            Text::make('Company Name', function($request) {
                return optional($this->company)['name'];
            })->onlyOnExport(),
            Text::make('Function', 'function_description'),
            Text::make('Telephone')->nullable(),
            Text::make('Mobile')->nullable(),
            BelongsToMany::make('Brands')->canSee(function ($request) {
                return $request->user()->hasRole('Administrator');
            }),
            Text::make('Brands', function ($request) {
                return $this->brands->pluck('name')->implode(', ');
            })->onlyOnExport(),
            MorphToMany::make('Roles', 'roles', \Vyuldashev\NovaPermission\Role::class)->canSee(function ($request) {
                return $request->user()->hasRole('Administrator');
            }),
            Text::make('Roles', function ($request) {
                return $this->roles->pluck('name')->implode(', ');
            }),
            MorphToMany::make('Permissions', 'permissions',
                \Vyuldashev\NovaPermission\Permission::class)->canSee(function ($request) {
                return $request->user()->hasRole('Administrator');
            }),
            Select::make('Stock Type')->options([
                'both' => 'Both',
                'NC' => 'New Cars',
                'UC' => 'Used Cars'
            ])->rules('required')->readonly(function($request) {
                return !$request->user()->hasRole('Administrator');
            }),
            Select::make('Import Types')->options([
                'I' => 'Import only',
                'R' => 'Retail only',
                'IR' => 'Import & Retail'
            ])->rules('required')->readonly(function($request) {
                return !$request->user()->hasRole('Administrator');
            }),
            MorphToMany::make('Last login', 'logInActivity')->canSee(function ($request) {
                return false;
            }),
            Text::make('Last login', function ($request) {
                if (!count($this->logInActivity)) {
                    return '—';
                }

                $lastActivityItem = $this->logInActivity->last();

                return $lastActivityItem->created_at->format('Y-m-d H:i:s');
            }),
            Text::make('Api Token')->nullable()->readonly(function($request) {
                return !$request->user()->hasRole('Administrator');
            })->hideFromIndex(),
            Multiselect::make('Vehicle Type')->options([
                'LCV' => 'LCV',
                'Passenger' => 'Passenger',
                'Truck' => 'Truck'
            ])->rules('required')->saveAsJson(),
            Text::make('Company suggestion')->nullable()->readonly(function($request) {
                return !$request->user()->hasRole('Administrator');
            })->hideFromIndex()
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
        return [
            (new StaticOptionsSelect('stock_type', \App\User::class)),
            (new StaticOptionsSelect('country', \App\User::class)),
            (new RoleFilter()),
            (new CompanyFilter()),
            (new LoggedInFilter())
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
            (new InviteUser()),
            (new DownloadExcel)->withHeadings()->only([
                'id',
                'name',
                'email',
                'country',
                'function_description',
                'telephone',
                'mobile',
                'Brands',
                'Company Name',
                'Roles',
                'stock_type',
                'import_types',
                'comment'
            ])
        ];
    }

    public static function availableForNavigation(Request $request)
    {
        return $request->user()->hasRole('Administrator');
    }

    /**
     * Build an "index" query for the given resource.
     *
     * @param  NovaRequest
     * @param  \Illuminate\Database\Eloquent\Builder  $query
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public static function indexQuery(NovaRequest $request, $query)
    {
        if ($request->user()->hasRole('Administrator')) {
            return $query;
        }
        return $query->where('id', $request->user()->id);
    }

}
