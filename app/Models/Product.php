<?php

namespace App\Models;

use Carbon\Carbon;
use App\Models\Order;
use App\Models\Category;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Product extends Model
{
    use HasFactory;

    protected $fillable = ['category_id','name','quantity',
    'slug','description','price','status','featured','quantity'];

    protected $appends = ['created_from'];


    public function getCreatedFromAttribute()
    {
      return Carbon::parse($this->created_at)->diffForHumans();
    }

    // subCategory
    public function category()
    {
    return $this->belongsTo(Category::class);
    }


}
