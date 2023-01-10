<?php
namespace App\Policies;

use App\Instruction;
use App\User;
use Illuminate\Auth\Access\HandlesAuthorization;

class InstructionPolicy
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
    }

    /**
     * Determine whether the user can view the model.
     *
     * @param  \App\User  $user
     * @param  \App\Instruction  $instruction
     * @return mixed
     */
    public function view(User $user, Instruction $instruction)
    {
        //
    }

    /**
     * Determine whether the user can create models.
     *
     * @param  \App\User  $user
     * @return mixed
     */
    public function create(User $user)
    {
        //
    }

    /**
     * Determine whether the user can update the model.
     *
     * @param  \App\User  $user
     * @param  \App\Instruction  $instruction
     * @return mixed
     */
    public function update(User $user, Instruction $instruction)
    {
        //
    }

    /**
     * Determine whether the user can delete the model.
     *
     * @param  \App\User  $user
     * @param  \App\Instruction  $instruction
     * @return mixed
     */
    public function delete(User $user, Instruction $instruction)
    {
        //
    }

    /**
     * Determine whether the user can restore the model.
     *
     * @param  \App\User  $user
     * @param  \App\Instruction  $instruction
     * @return mixed
     */
    public function restore(User $user, Instruction $instruction)
    {
        //
    }

    /**
     * Determine whether the user can permanently delete the model.
     *
     * @param  \App\User  $user
     * @param  \App\Instruction  $instruction
     * @return mixed
     */
    public function forceDelete(User $user, Instruction $instruction)
    {
        //
    }
}
