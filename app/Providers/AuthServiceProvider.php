<?php

namespace App\Providers;

// use Illuminate\Support\Facades\Gate;
use App\Models\Role;
use App\Models\test;
use App\Models\User;
use App\Models\Order;
use App\Models\Product;
use App\Models\Category;
use App\Models\Permission;
use App\Policies\TestPolicy;
use App\Policies\User\UserPolicy;
use App\Policies\Order\OrderPolicy;
use Illuminate\Support\Facades\Gate;
use App\Policies\Product\ProductPolicy;
use App\Policies\Category\CategoryPolicy;
use App\Policies\Permission\PermissionPolicy;
use Illuminate\Foundation\Support\Providers\AuthServiceProvider as ServiceProvider;

class AuthServiceProvider extends ServiceProvider
{
    /**
     * The model to policy mappings for the application.
     *
     * @var array<class-string, class-string>
     */
    protected $policies = [
        // 'App\Models\Model' => 'App\Policies\ModelPolicy',
        User::class => UserPolicy::class,
        Product::class => ProductPolicy::class,
        Category::class => CategoryPolicy::class,
        Order::class => OrderPolicy::class,

    ];

    /**
     * Register any authentication / authorization services.
     */
    public function boot(): void
    {
        $this->registerPolicies();

        // $roles = Role::with('permissions')->get();
        // $permissionsArray = [];

        // foreach ($roles as $role) {
        //     foreach ($role->permissions as $permission) {
        //         $permissionsArray[$permission->title][] = $role->id;
        //     }
        // }

        // foreach ($permissionsArray as $title => $roles) {
        //     Gate::define($title, function ($user) use ($roles) {
        //         return count(array_intersect($user->roles->pluck('id')->toArray(), $roles)) > 0;
        //     });
        // }
    }
}
