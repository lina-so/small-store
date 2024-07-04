<?php

namespace App\Models;

use Carbon\Carbon;
use App\Models\Product;
use App\Models\Category;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Category extends Model
{
    use HasFactory;
    protected $fillable = ['name','parent_id','status','slug'];

    protected $appends = ['created_from'];


    public function getCreatedFromAttribute()
    {
      return Carbon::parse($this->created_at)->diffForHumans();
    }

    public function products()
    {
        return $this->hasMany(Product::class);
    }

    public function subcategories()
    {
        return $this->hasMany(Category::class, 'parent_id', 'id')->with('subcategories','products');
    }
}
