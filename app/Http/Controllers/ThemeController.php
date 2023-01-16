<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreThemeRequest;
use App\Http\Requests\UpdateThemeRequest;
use App\Models\Theme;
use Illuminate\Http\Request;

class ThemeController extends Controller
{

    /**
     * @api {get} /theme theme.index
     * @apiName theme.index
     * @apiGroup theme
     */
    public function index(Request $request)
    {
        $themes = Theme::query()
            ->latest()
            ->get();
        return response()->json($themes);
    }


    /**
     * @api {get} /shop/{shop} shop.show
     * @apiName shop.show
     * @apiGroup shop
     */
    public function show(Theme $theme)
    {
        return response()->json($theme);
    }

}
