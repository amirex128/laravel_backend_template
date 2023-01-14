<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreArticleCategoryRequest;
use App\Http\Requests\UpdateArticleCategoryRequest;
use App\Models\ArticleCategory;
use Illuminate\Http\Request;

class ArticleCategoryController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $q = ArticleCategory::query();

        if ($request->has('search')) {
            $q->where('name', 'like', '%' . $request->search . '%');
        }

        $result = $q->latest()->paginate($request->input('per_page', 10));

        return response()->json($result);
    }


    /**
     * Store a newly created resource in storage.
     *
     * @param \App\Http\Requests\StoreArticleCategoryRequest $request
     * @return \Illuminate\Http\Response
     */
    public function store(StoreArticleCategoryRequest $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param \App\Models\ArticleCategory $articleCategory
     * @return \Illuminate\Http\Response
     */
    public function show(ArticleCategory $articleCategory)
    {
        //
    }


    /**
     * Update the specified resource in storage.
     *
     * @param \App\Http\Requests\UpdateArticleCategoryRequest $request
     * @param \App\Models\ArticleCategory $articleCategory
     * @return \Illuminate\Http\Response
     */
    public function update(UpdateArticleCategoryRequest $request, ArticleCategory $articleCategory)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param \App\Models\ArticleCategory $articleCategory
     * @return \Illuminate\Http\Response
     */
    public function destroy(ArticleCategory $articleCategory)
    {
        //
    }
}
