<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreArticleCategoryRequest;
use App\Http\Requests\UpdateArticleCategoryRequest;
use App\Models\ArticleCategory;
use Illuminate\Http\Request;

class ArticleCategoryController extends Controller
{
    /**
     * @api {get} /article-category article-category.index
     * @apiName article-category.index
     * @apiGroup article-category
     * @apiParam {Number} [per_page=10] per page
     */
    public function index(Request $request)
    {
        $articleCategories = ArticleCategory::query()
            ->where('user_id', auth()->id())
            ->where('shop_id', $request->input('shop_id'))
            ->latest()
            ->paginate($request->input('per_page', 10));

        return response()->json($articleCategories);
    }


    /**
     * @api {post} /article-category article-category.store
     * @apiName article-category.store
     * @apiGroup article-category
     * @apiBody {String} name
     * @apiBody {String} description
     * @apiBody {Number} shop_id
     */
    public function store(StoreArticleCategoryRequest $request)
    {
        $request->merge(['user_id' => auth()->id()]);
        $articleCategory = ArticleCategory::query()->create($request->validated());

        return response()->json($articleCategory);
    }

    /**
     * @api {get} /article-category/:id article-category.show
     * @apiName article-category.show
     * @apiGroup article-category
     * @apiParam {Number} id model id
     */
    public function show(ArticleCategory $articleCategory)
    {
        return response()->json($articleCategory);
    }


    /**
     * @api {put} /article-category/:id article-category.update
     * @apiName article-category.update
     * @apiGroup article-category
     * @apiBody {String} name
     * @apiBody {String} description
     * @apiBody {Number} sort
     * @apiBody {Number} shop_id
     * @apiParam {Number} id model id
     */
    public function update(UpdateArticleCategoryRequest $request, ArticleCategory $articleCategory)
    {
        $articleCategory->update($request->validated());

        return response()->json($articleCategory);
    }


    /**
     * @api {delete} /article-category/:id article-category.destroy
     * @apiName article-category.destroy
     * @apiGroup article-category
     * @apiParam {Number} id model id
     */
    public function destroy(ArticleCategory $articleCategory)
    {
        $articleCategory->delete();

        return response()->json([
            'message' => 'دسته بندی مقاله با موفقیت حذف شد',
        ]);
    }
}
