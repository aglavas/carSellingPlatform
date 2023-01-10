<?php

namespace App\Providers;

use App\Policies\TransactionPolicy;
use App\Policies\VehiclePolicy;
use App\StockFCA;
use App\StockMercedes;
use App\StockOpel;
use App\StockPeugeotCitroenDs;
use App\StockUsedCentralEurope;
use App\StockVehicle;
use App\Transaction;
use Illuminate\Foundation\Support\Providers\AuthServiceProvider as ServiceProvider;
use Illuminate\Support\Facades\Gate;

class AuthServiceProvider extends ServiceProvider
{
    /**
     * The policy mappings for the application.
     *
     * @var array
     */
    protected $policies = [
         StockVehicle::class => VehiclePolicy::class,
         Transaction::class => TransactionPolicy::class
    ];

    /**
     * Register any authentication / authorization services.
     *
     * @return void
     */
    public function boot()
    {
        $this->registerPolicies();

        // Implicitly grant "Super Admin" role all permissions
        // This works in the app by using gate-related functions like auth()->user->can() and @can()
        Gate::before(function ($user, $ability) {
            return $user->hasRole('Administrator') ? true : null;
        });
    }
}
