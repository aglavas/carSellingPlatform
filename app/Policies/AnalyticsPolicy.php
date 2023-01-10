<?php

namespace App\Policies;

use App\Analytics;
use App\User;
use Illuminate\Auth\Access\HandlesAuthorization;

class AnalyticsPolicy
{
    use HandlesAuthorization;

    /**
     * Determine whether the user can view any models.
     *
     * @param \App\User $user
     * @return mixed
     */
    public function viewAny(User $user)
    {
        return $user->can('view-analytics');
    }

    /**
     * Determine whether the user can view the model.
     *
     * @param \App\User $user
     * @param \App\Analytics $stockMercedes
     * @return mixed
     */
    public function view(User $user, Analytics $analytics)
    {
        return $user->can('view-analytics');
    }

}
