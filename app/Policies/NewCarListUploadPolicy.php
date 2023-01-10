<?php

namespace App\Policies;

use App\NewCarListUpload;
use App\User;
use Illuminate\Auth\Access\HandlesAuthorization;

class NewCarListUploadPolicy
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
        return ($user->can('upload-stock-list') && $user->stock_type === 'NC') || $user->can('upload-any-stock-list');
    }

    /**
     * Determine whether the user can view the model.
     *
     * @param  \App\User  $user
     * @param  \App\NewCarListUpload  $newCarListUpload
     * @return mixed
     */
    public function view(User $user, NewCarListUpload $newCarListUpload)
    {
        return $user->can('upload-stock-list') && $newCarListUpload->uploader->id === $user->id;
    }

    /**
     * Determine whether the user can create models.
     *
     * @param  \App\User  $user
     * @return mixed
     */
    public function create(User $user)
    {
        return $user->can('upload-stock-list');
    }

    /**
     * Determine whether the user can update the model.
     *
     * @param  \App\User  $user
     * @param  \App\NewCarListUpload  $newCarListUpload
     * @return mixed
     */
    public function update(User $user, NewCarListUpload $newCarListUpload)
    {
        return false;
        //return $user->can('upload-stock-list') && $newCarListUpload->uploader->id === $user->id;
    }

    /**
     * Determine whether the user can delete the model.
     *
     * @param  \App\User  $user
     * @param  \App\NewCarListUpload  $newCarListUpload
     * @return mixed
     */
    public function delete(User $user, NewCarListUpload $newCarListUpload)
    {
        return $user->can('upload-stock-list') && $newCarListUpload->uploader->id === $user->id;
    }

    /**
     * Determine whether the user can restore the model.
     *
     * @param  \App\User  $user
     * @param  \App\NewCarListUpload  $newCarListUpload
     * @return mixed
     */
    public function restore(User $user, NewCarListUpload $newCarListUpload)
    {
        return $user->can('upload-stock-list') && $newCarListUpload->uploader->id === $user->id;
    }

    /**
     * Determine whether the user can permanently delete the model.
     *
     * @param  \App\User  $user
     * @param  \App\NewCarListUpload  $newCarListUpload
     * @return mixed
     */
    public function forceDelete(User $user, NewCarListUpload $newCarListUpload)
    {
        return $user->can('upload-stock-list') && $newCarListUpload->uploader->id === $user->id;
    }
}
