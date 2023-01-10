<?php

namespace App\Policies;

use App\StockUsedCentralEurope;
use App\User;
use Illuminate\Auth\Access\HandlesAuthorization;
use Illuminate\Database\Eloquent\Model;

class VehiclePolicy
{
    use HandlesAuthorization;

    /**
     * Create a new policy instance.
     *
     * @return void
     */
    public function __construct()
    {
        //
    }

    /**
     * Check if user can modify existing vehicle
     *
     * @param User $user
     * @param Model $vehicle
     * @return bool
     */
    public function modify(User $user, Model $vehicle)
    {
        $country = strtolower($user->country);
        $company = $user->company->name;

        return (($vehicle->country === $country) && ($vehicle->company === $company));
    }
}
