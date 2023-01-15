<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreCommentRequest;
use App\Http\Requests\UpdateCommentRequest;
use App\Models\Comment;
use App\Models\Product;
use Illuminate\Http\Request;

class CommentController extends Controller
{

    /**
     * @api {get} /comment comment.index
     * @apiName comment.index
     * @apiGroup comment
     * @apiParam {Number} [per_page=10] per page
     */
    public function index(Request $request)
    {
        $comments = Product::query()
            ->findOrFail($request->input('product_id'))
            ->comments()
            ->latest()
            ->paginate($request->input('per_page', 20));
        return response()->json($comments);
    }


    /**
     * @api {post} /comment comment.store
     * @apiName comment.store
     * @apiGroup comment
     * @apiBody  {String} title title
     * @apiBody {String} body body
     * @apiBody {Number} shop_id shop_id
     * @apiBody {Number} product_id product_id
     */
    public function store(StoreCommentRequest $request)
    {
        $request->merge(['user_id' => auth()->id()]);
        $comment = Comment::create($request->validated());
        $comment->products()->attach($request->input('product_id'));

        return response()->json($comment);
    }


    /**
     * @api {get} /comment/{comment} comment.show
     * @apiName comment.show
     * @apiGroup comment
     * @apiParam {Number} id model id
     */
    public function show(Comment $comment)
    {
        return response()->json($comment);
    }


    /**
     * @api {delete} /comment/:id comment.destroy
     * @apiName comment.destroy
     * @apiGroup comment
     * @apiParam {Number} id model id
     */
    public function destroy(Comment $comment)
    {
        $comment->delete();
        return response()->json([
            'message' => 'نظر با موفقیت حذف شد',
        ]);
    }
}
