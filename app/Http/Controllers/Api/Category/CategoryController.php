<?php

namespace App\Http\Controllers\Api\Category;

use App\Models\Category;
use Illuminate\Http\Request;
use App\Traits\ApiResponseTrait;
use App\Http\Controllers\Controller;
use App\Services\Category\CategoryService;
use App\Http\Requests\Category\CategoryRequest;

class CategoryController extends Controller
{
    use ApiResponseTrait;
    protected $categoryService;

    public function __construct(CategoryService $categoryService)
    {
        $this->categoryService = $categoryService;
    }

/*************************************************************************/
    public function index()
    {

        $this->authorize('viewAny', Category::class);

        $categories_with_sub_categories =$this->categoryService->index();
        return $this->apiSuccess('all category with sub category',$categories_with_sub_categories, 200);


    }

/*************************************************************************/

    public function store(CategoryRequest $request)
    {

        $this->authorize('create', Category::class);

        $category = $this->categoryService->createCategory($request);
        return $this->apiSuccess('category created successfully ',$category, 201);

    }

/*************************************************************************/

    public function show(string $id)
    {
        $this->authorize('view', Category::class);

        $category = $this->categoryService->showCategory($id);
        return $this->apiSuccess('category data retrieved successfully',$category, 200);

    }

/*************************************************************************/

    public function update(CategoryRequest $request, string $id)
    {
        //  $user = auth('sanctum')->user();
        // dd($user->hasPermissionTo('update-category'));
        $this->authorize('update',Category::class);

        $category = $this->categoryService->updateCategory($request,$id);
        return $this->apiSuccess('category updated successfully',$category, 201);


    }

/*************************************************************************/

    public function destroy(string $id)
    {
        $this->authorize('delete', Category::class);

        $category = $this->categoryService->deleteCategory($id);
        return $this->apiSuccess('category deleted successfully', 200);


    }
}
