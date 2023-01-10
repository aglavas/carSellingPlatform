<?php
namespace App\Policies;

use App\StockPeugeotCitroenDs;
use App\User;
use Illuminate\Auth\Access\HandlesAuthorization;

class StockPeugeotCitroenDsPolicy
{
    use HandlesAuthorization;

    /**
     * Determine whether the user can view any models.
     *
     * @param  \App\User  $user
     * @return mixed
     */
    public function viewAny(User $user)
    {
        return false;
        return $user->can('view-stock-list') || $user->hasRole('Logistics');
    }

    /**
     * Determine whether the user can view the model.
     *
     * @param  \App\User  $user
     * @param  \App\StockPeugeotCitroenDs  $stockPeugeotCitroenDs
     * @return mixed
     */
    public function view(User $user, StockPeugeotCitroenDs $stockPeugeotCitroenDs)
    {
        return $user->can('view-stock-list') || $user->hasRole('Logistics');
    }

}
