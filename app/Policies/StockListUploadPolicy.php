<?php

namespace App\Policies;

use App\StockListUpload;
use App\User;
use Illuminate\Auth\Access\HandlesAuthorization;

class StockListUploadPolicy
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
        return ($user->can('upload-stock-list') && $user->stock_type === 'UC') || $user->can('upload-any-stock-list');
    }

    /**
     * Determine whether the user can view the model.
     *
     * @param  \App\User  $user
     * @param  \App\StockListUpload  $stockListUpload
     * @return mixed
     */
    public function view(User $user, StockListUpload $stockListUpload)
    {
        return $user->can('upload-stock-list') && $stockListUpload->uploader->id === $user->id;
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
     * @param  \App\StockListUpload  $stockListUpload
     * @return mixed
     */
    public function update(User $user, StockListUpload $stockListUpload)
    {
        //return $user->can('upload-stock-list') && $stockListUpload->uploader->id === $user->id;
        return false;
    }

    /**
     * Determine whether the user can delete the model.
     *
     * @param  \App\User  $user
     * @param  \App\StockListUpload  $stockListUpload
     * @return mixed
     */
    public function delete(User $user, StockListUpload $stockListUpload)
    {
        return $user->can('upload-stock-list') && $stockListUpload->uploader->id === $user->id;
    }

    /**
     * Determine whether the user can restore the model.
     *
     * @param  \App\User  $user
     * @param  \App\StockListUpload  $stockListUpload
     * @return mixed
     */
    public function restore(User $user, StockListUpload $stockListUpload)
    {
        return $user->can('upload-stock-list') && $stockListUpload->uploader->id === $user->id;
    }

    /**
     * Determine whether the user can permanently delete the model.
     *
     * @param  \App\User  $user
     * @param  \App\StockListUpload  $stockListUpload
     * @return mixed
     */
    public function forceDelete(User $user, StockListUpload $stockListUpload)
    {
        return $user->can('upload-stock-list') && $stockListUpload->uploader->id === $user->id;
    }
}
