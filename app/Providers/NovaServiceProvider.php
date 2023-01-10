<?php

namespace App\Providers;

use App\Nova\Dashboards\WeeklyActivity;
use Efdi\Announcement\Announcement;
use Efdi\ContactForm\ContactForm;
use Efdi\Instruction\Instruction;
use Efdi\CarUploadNotification\CarUploadNotification;
use Illuminate\Support\Facades\Gate;
use Laravel\Nova\Events\ServingNova;
use Laravel\Nova\Nova;
use Laravel\Nova\NovaApplicationServiceProvider;
use Laravel\Nova\Tools\ResourceManager;

class NovaServiceProvider extends NovaApplicationServiceProvider
{
    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        Nova::serving(function (ServingNova $event) {
            Nova::style('carmarket-theme', __DIR__.'/../../resources/css/custom.css');
        });
        parent::boot();
    }

    /**
     * Get the tools that should be listed in the Nova sidebar.
     *
     * @return array
     */
    public function tools()
    {
        $registeredTools = Nova::$tools;

        $overrideKey = null;

        foreach ($registeredTools as $key => $tool) {
            if ($tool instanceof ResourceManager) {
                $overrideKey = $key;
            }
        }

        Nova::$tools[$overrideKey] = new \App\Nova\Tools\ResourceManager();

        return [
            \Vyuldashev\NovaPermission\NovaPermissionTool::make()->canSee(function($request) {
                return $request->user()->hasRole('Administrator');
            }),
            ContactForm::make()
        ];
    }

    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        //
    }

    /**
     * Register the Nova routes.
     *
     * @return void
     */
    protected function routes()
    {
        Nova::routes()
            ->withAuthenticationRoutes()
            ->withPasswordResetRoutes()
            ->register();
    }

    /**
     * Register the Nova gate.
     *
     * This gate determines who can access Nova in non-local environments.
     *
     * @return void
     */
    protected function gate()
    {
        Gate::define('viewNova', function ($user) {
            return in_array($user->email, [
                //
            ]);
        });
    }

    /**
     * Get the cards that should be displayed on the default Nova dashboard.
     *
     * @return array
     */
    protected function cards()
    {
        return [
            //(new CarUploadNotification())->notification(),
            (new Announcement())->latestAnnouncements(),
            (new Instruction())->instruction(),
        ];
    }

    /**
     * Get the extra dashboards that should be displayed on the Nova dashboard.
     *
     * @return array
     */
    protected function dashboards()
    {
        return [
            (new WeeklyActivity())->canSee(function ($request) {
                return $request->user()->hasRole('Administrator');
            })
        ];
    }
}
