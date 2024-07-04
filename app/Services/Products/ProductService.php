<?php

namespace App\Services\Products;

use App\Models\Product;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use App\Traits\Files\FileOperationsTrait;

class ProductService
{
    use FileOperationsTrait;

/********************************************************************************************/

    public function index()
    {
        // $all_products = Product::select(['id','name','slug','price'])->with('category')->get();
        // return $all_products;

        $all_products = Product::with(['category' => function($query) {
            $query->select(['id', 'name']);
        }])->select(['id', 'name', 'slug', 'price', 'category_id'])->get();

        return $all_products;
    }


/********************************************************************************************/

    public function createProduct($requestData)
    {
        DB::beginTransaction();

        try {
            $data = $requestData->validated();

            if($requestData->hasFile('image'))
            {
                $file =$requestData->file('image') ;
                $imagePath = $this->generatePath($file, $data['name']);
                $this->uploadFile($file, $imagePath);

            }


            $slug = Str::slug($data['name']);
            $data['slug'] = $slug;

            $product = Product::create($data);

            DB::commit();
            return $product;
        } catch (\Exception $e) {
            DB::rollback();
            return $e->getMessage();
        }
    }
/********************************************************************************************/

    public function generatePath($image , $product_name)
    {
        $folderName = 'products';
        $folderPath = 'images/' . $folderName .'/'. $product_name ;
        return $folderPath;
    }

/********************************************************************************************/
    public function updateProduct($requestData, $productId)
    {
        DB::beginTransaction();

        try {
            $data = $requestData->validated();

            $product = Product::findOrFail($productId);

            $slug = Str::slug($data['name']);
            $data['slug'] = $slug;

            $product->update($data);

            DB::commit();
            return $product;
        } catch (\Exception $e) {
            DB::rollback();
            return $e->getMessage();
        }
    }
/*************************************************************************************************/
    public function showProduct($id){
        $product = Product::with('category')->findOrFail($id);
        return $product;
    }
/********************************************************************************************/

    public function deleteProduct($id)
    {
        $product = Product::findOrFail($id);
        $product->delete();

    }

}

