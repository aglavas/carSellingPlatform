<?php
namespace App\Policies;

use App\StockFCA;
use App\User;
use Illuminate\Auth\Access\HandlesAuthorization;

class StockFCAPolicy
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
     * @param  \App\StockFCA  $stockFCA
     * @return mixed
     */
    public function view(User $user, StockFCA $stockFCA)
    {
        return $user->can('view-stock-list') || $user->hasRole('Logistics');
    }


}
