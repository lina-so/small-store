<?php

namespace App\Policies\Category;

use App\Models\User;
use App\Models\Category;
use Illuminate\Auth\Access\Response;
use Illuminate\Auth\Access\HandlesAuthorization;

class CategoryPolicy
{
    use HandlesAuthorization;
    public function before()
        {
            \Log::info('before method called.');
            return true;
        }

    /**
     * Determine whether the user can view any models.
     */
    public function viewAny(User $user): bool
    {
        return $user->hasPermissionTo('view-category');

    }

    /**
     * Determine whether the user can view the model.
     */
    public function view(User $user, Category $category): bool
    {
        return $user->hasPermissionTo('show-category');
    }


    public function create(User $user): bool
    {
        return $user->hasPermissionTo('create-category');
    }


    public function update(User $user,Category $category): bool
    {
        return $user->hasPermissionTo('update-category');

    }

    /**
     * Determine whether the user can delete the model.
     */
    public function delete(User $user,Category $category): bool
    {
        return $user->hasPermissionTo('delete-category');
    }

    /**
     * Determine whether the user can restore the model.
     */
    public function restore(User $user, category $category): bool
    {
        //
    }

    /**
     * Determine whether the user can permanently delete the model.
     */
    public function forceDelete(User $user, category $category): bool
    {
        //
    }
}
