<?php

namespace App\Http\Controllers\Api\Products;

use App\Models\Product;
use Illuminate\Http\Request;
use App\Traits\ApiResponseTrait;
use App\Http\Controllers\Controller;
use App\Services\Products\ProductService;
use App\Http\Requests\Product\ProductRequest;

class ProductController extends Controller
{
    use ApiResponseTrait;

    protected $productService;

    public function __construct(ProductService $productService)
    {
        $this->productService = $productService;
    }

/*************************************************************************/
    public function index()
    {
        // $user = auth('sanctum')->user();
        // dd($user->hasRole('owner'));
        // dd($user);

        $this->authorize('viewAny', Product::class);
    //   dd($user->hasPermissionTo('view-product'));

        $products =$this->productService->index();
        return $this->apiSuccess('all products',$products, 200);

    }

/*************************************************************************/

    public function store(ProductRequest $request)
    {
        $this->authorize('create', Product::class);

        $product = $this->productService->createProduct($request);
        return $this->apiSuccess('product created successfully ',$product, 201);

    }

/*************************************************************************/

    public function show(string $id)
    {
        $this->authorize('view', $id);

        $product = $this->productService->showProduct($id);
        return $this->apiSuccess('product data retrieved successfully',$product, 200);

    }

/*************************************************************************/

    public function update(ProductRequest $request, string $id)
    {
        $this->authorize('update', $id);

        $product = $this->productService->updateProduct($request,$id);
        return $this->apiSuccess('product updated successfully',$product, 201);

    }

/*************************************************************************/

    public function destroy(string $id)
    {
        $this->authorize('delete', $id);

        $product = $this->productService->deleteProduct($id);
        return $this->apiSuccess('product deleted successfully',$product, 200);


    }
}
