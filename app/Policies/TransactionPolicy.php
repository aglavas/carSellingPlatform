<?php

namespace App\Policies;

use App\Transaction;
use App\User;
use Illuminate\Auth\Access\HandlesAuthorization;

class TransactionPolicy
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
     * Determine whether the user can manage transactions
     *
     * @param User $user
     * @param Transaction $transaction
     * @return bool
     */
    public function manage(User $user, Transaction $transaction)
    {
        return ( ($user->country === $transaction->country) && ($user->company_id === $transaction->seller_company_id) );
    }
}
