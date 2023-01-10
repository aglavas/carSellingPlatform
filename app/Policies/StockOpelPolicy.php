<?php
namespace App\Policies;

use App\StockOpel;
use App\User;
use Illuminate\Auth\Access\HandlesAuthorization;

class StockOpelPolicy
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
     * @param  \App\StockOpel  $stockOpel
     * @return mixed
     */
    public function view(User $user, StockOpel $stockOpel)
    {
        return $user->can('view-stock-list') || $user->hasRole('Logistics');
    }


}
