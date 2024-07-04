<?php

namespace App\Models;

use App\Models\User;
use App\Models\Product;
use Illuminate\Support\Facades\Auth;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Prunable;

use Illuminate\Database\Eloquent\Factories\HasFactory;

class Order extends Model
{
    // php artisan model:prune --pretend

    use HasFactory,Prunable;
    protected $fillable = ['user_id','product_id','status','ip_address','quantity'];


    public function prunable(): Builder
    {
        return static::where('status','delivered')->whereDate('updated_at','=',now()->subDay(3));
    }


    protected static function boot()
    {
        parent::boot();
        static::creating(function ($order) {
            $order->ip_address = request()->ip();
        });
    }

    public function scopeAuthUser(Builder $query): void
    {
        $user = Auth::user();
        $query->where('user_id', $user->id);
    }

    public function scopeNonAuthUser(Builder $query): void
    {
        $user = Auth::user();
        $query->where('ip_address', request()->ip());
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function product()
    {
        return $this->belongsTo(Product::class);
    }

    public function userByIp()
    {
        return $this->belongsTo(User::class);
    }
}

