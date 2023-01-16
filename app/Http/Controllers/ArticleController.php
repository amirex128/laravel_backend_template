<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreArticleRequest;
use App\Http\Requests\UpdateArticleRequest;
use App\Models\Article;
use Illuminate\Http\Request;

class ArticleController extends Controller
{

    /**
     * @api {get} /article article.index
     * @apiName article.index
     * @apiGroup article
     * @apiHeader {String} Authorization token
     * @apiParam {Number} [per_page=10] per page
     */
    public function index(Request $request)
    {
        $articles = Article::query()
            ->where('user_id', auth()->id())
            ->where('shop_id', $request->input('shop_id'))
            ->latest()
            ->paginate($request->input('per_page', 10));

        return response()->json($articles);
    }



    /**
     * @api {post} /article article.store
     * @apiName article.store
     * @apiGroup article
     * @apiHeader {String} Authorization token
     * @apiBody {String} title title
     * @apiBody {String} body body
     * @apiBody {Number} gallery_id gallery_id
     * @apiBody {Number} shop_id shop_id
     */
    public function store(StoreArticleRequest $request)
    {
        $request->merge(['user_id' => auth()->id()]);
        $article = Article::query()->create($request->validated());

        return response()->json($article);
    }

    /**
     * @api {get} /article/:id article.show
     * @apiName article.show
     * @apiGroup article
     * @apiHeader {String} Authorization token
     * @apiParam {Number} id model id
     */
    public function show(Article $article)
    {
        return response()->json($article);
    }



    /**
     * @api {put} /article/:id article.update
     * @apiName article.update
     * @apiGroup article
     * @apiHeader {String} Authorization token
     * @apiBody {String} title title
     * @apiBody {String} body body
     * @apiBody {Number} gallery_id gallery_id
     * @apiBody {Number} shop_id shop_id
     * @apiParam {Number} id model id
     */
    public function update(UpdateArticleRequest $request, Article $article)
    {
        $article->update($request->validated());

        return response()->json($article);
    }


    /**
     * @api {delete} /article/:id article.destroy
     * @apiName article.destroy
     * @apiGroup article
     * @apiHeader {String} Authorization token
     * @apiParam {Number} id model id
     */
    public function destroy(Article $article)
    {
        $article->delete();

        return response()->json([
            'message' => 'مقاله با موفقیت حذف شد',
        ]);
    }
}
