<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use App\Models\Role;
use App\Models\Order;
use App\Models\Permission;
use Laravel\Sanctum\HasApiTokens;
use Illuminate\Notifications\Notifiable;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;

class User extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     *
     */
    protected $fillable = [
        'name',
        'email',
        'password',
        'first_name',
        'last_name',
        'date_of_birth',
        'user_address',
        'ip_address',
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
        'password'=> 'hashed',
    ];


    protected static function boot()
    {
        parent::boot();
        static::creating(function ($user) {
            $user->user_address = request()->postal_code . ' ' . request()->city . ' ' . request()->country;
            $user->ip_address = request()->ip();
        });
    }

    public function scopeIsAdmin(Builder $query): void
    {
        $query->where('admin', 1);
    }


    public function ordersBelongsIpAddress()
    {
        return $this->hasMany(Order::class, 'ip_address', 'ip_address');
    }

    public function ordersBelongsId()
    {
        return $this->hasMany(Order::class, 'user_id', 'id');
    }

    public function roles()
    {
        return $this->belongsToMany(Role::class);
    }

    public function hasPermissionTo($permission)
    {
        return $this->roles()->whereHas('permissions', function ($query) use ($permission) {
            $query->where('name', $permission)
            ->where('type','allow');
            ;
        })->exists();
    }


    // public function hasRole($role)
    // {
    //     return $this->roles->contains('name', $role);
    // }

    // public function permissions()
    // {
    //     return $this->hasManyThrough(
    //         Permission::class,
    //         Role::class,
    //         'user_id',
    //         'role_id',
    //         'id',
    //         'id'
    //     )->where('permission_role.type', 'allow');;
    // }




}
