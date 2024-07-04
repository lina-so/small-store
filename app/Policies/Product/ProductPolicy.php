<?php

namespace App\Policies\Product;

use App\Models\User;
use App\Models\Product;
use Illuminate\Auth\Access\Response;
use Illuminate\Auth\Access\HandlesAuthorization;

class ProductPolicy
{
    use HandlesAuthorization;

    // public function before()
    // {
    //     \Log::info('before method called.');
    //     return true;
    // }

    public function viewAny(User $user): bool
    {
        // return $user->hasRole('owner');

        return $user->hasPermissionTo('view-product');

    }


    public function view(User $user, $id): bool
    {
        $product = Product::findOrFail($id);
        return $user->hasPermissionTo('show-product');
    }


    public function create(User $user): bool
    {
        return $user->hasPermissionTo('create-product');
    }


    public function update(User $user, $id): bool
    {
        $product = Product::findOrFail($id);
        return $user->hasPermissionTo('update-product');

    }

    /**
     * Determine whether the user can delete the model.
     */
    public function delete(User $user,$id): bool
    {
        $product = Product::findOrFail($id);
        return $user->hasPermissionTo('delete-product');
    }

    /**
     * Determine whether the user can restore the model.
     */
    public function restore(User $user, Product $product): bool
    {
        //
    }

    /**
     * Determine whether the user can permanently delete the model.
     */
    public function forceDelete(User $user, Product $product): bool
    {
        //
    }
}
