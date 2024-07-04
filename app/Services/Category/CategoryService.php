<?php

namespace App\Services\Category;

use App\Models\Category;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

class CategoryService
{

/********************************************************************************************/

    public function index()
    {
        $categories_with_sub_categories = Category::whereNull('parent_id')->with('subcategories.products','products')->get();
        return $categories_with_sub_categories;

        // $categories_with_subcategories_and_products = Category::with([
        //     'subcategories' => function ($query) {
        //         $query->select(['id', 'name','parent_id']);
        //     },
        //     'subcategories.products' => function ($query) {
        //         $query->select(['id', 'name', 'slug', 'price','category_id']);
        //     }, 'products' => function($query) {
        //     $query->select(['id', 'name', 'slug', 'price','category_id']);
        // }])->select(['id', 'name'])->get();

        // return $categories_with_subcategories_and_products;
    }

/********************************************************************************************/

    public function createCategory($requestData)
    {
        DB::beginTransaction();

        try {
            $data = $requestData->validated();

            $slug = Str::slug($data['name']);
            $data['slug'] = $slug;

            $category = Category::create($data);

            DB::commit();
            return $category;
        } catch (\Exception $e) {
            DB::rollback();
            return $e->getMessage();
        }
    }


/********************************************************************************************/
    public function updateCategory($requestData, $categoryId)
    {
        DB::beginTransaction();

        try {
            $data = $requestData->validated();

            $category = Category::findOrFail($categoryId);

            $slug = Str::slug($data['name']);
            $data['slug'] = $slug;

            $category->update($data);

            DB::commit();
            return $category;
        } catch (\Exception $e) {
            DB::rollback();
            return $e->getMessage();
        }
    }
/*************************************************************************************************/
    public function showCategory($id){
        $category = Category::with('subcategories')->findOrFail($id);
        return $category;
    }
/********************************************************************************************/

    public function deleteCategory($id)
    {
        $category = Category::findOrFail($id);
        $category->delete();

    }

}

