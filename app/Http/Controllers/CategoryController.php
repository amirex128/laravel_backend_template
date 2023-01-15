<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreCategoryRequest;
use App\Http\Requests\UpdateCategoryRequest;
use App\Models\Category;
use Illuminate\Http\Request;

class CategoryController extends Controller
{

    /**
     * @api {get} /category category.index
     * @apiName category.index
     * @apiGroup category
     * @apiParam {Number} [per_page=10] per page
     */
    public function index(Request $request)
    {
        $categories = Category::query()
            ->where('user_id', auth()->id())
            ->where('shop_id', $request->input('shop_id'))
            ->latest()
            ->paginate($request->input('per_page', 10));

        return response()->json($categories);
    }


    /**
     * @api {post} /category category.store
     * @apiName category.store
     * @apiGroup category
     * @apiBody  {String} name name
     * @apiBody {String} description description
     * @apiBody {Number} shop_id shop_id
     * @apiParam {Number} id model id
     */
    public function store(StoreCategoryRequest $request)
    {
        $request->merge(['user_id' => auth()->id()]);
        $category = Category::create($request->validated());

        return response()->json($category);
    }


    /**
     * @api {get} /category/:id category.show
     * @apiName category.show
     * @apiGroup category
     */
    public function show(Category $category)
    {
        return response()->json($category);
    }


    /**
     * @api {put} /category/:id category.update
     * @apiName category.update
     * @apiGroup category
     * @apiBody {String} name name
     * @apiBody {String} description description
     * @apiBody {Number} sort sort
     * @apiParam {Number} id model id
     */
    public function update(UpdateCategoryRequest $request, Category $category)
    {
        $category->update($request->validated());

        return response()->json($category);
    }


    /**
     * @api {delete} /category/:id category.destroy
     * @apiName category.destroy
     * @apiGroup category
     * @apiParam {Number} id model id
     */
    public function destroy(Category $category)
    {
        $category->delete();

        return response()->json(null, 204);
    }
}
