<?php

use App\Http\Controllers\AddressController;
use App\Http\Controllers\AdminApiAuthController;
use App\Http\Controllers\ArticleCategoryController;
use App\Http\Controllers\ArticleController;
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\CityController;
use App\Http\Controllers\CommentController;
use App\Http\Controllers\CustomerApiAuthController;
use App\Http\Controllers\CustomerController;
use App\Http\Controllers\DiscountController;
use App\Http\Controllers\DomainController;
use App\Http\Controllers\GalleryController;
use App\Http\Controllers\OptionController;
use App\Http\Controllers\OrderController;
use App\Http\Controllers\OrderItemController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\ProvinceController;
use App\Http\Controllers\ShopController;
use App\Http\Controllers\ThemeController;
use App\Http\Controllers\TicketController;
use App\Http\Controllers\UserApiAuthController;
use App\Models\Address;
use App\Models\Article;
use App\Models\ArticleCategory;
use App\Models\Category;
use App\Models\City;
use App\Models\Comment;
use App\Models\Customer;
use App\Models\Discount;
use App\Models\Domain;
use App\Models\Gallery;
use App\Models\Option;
use App\Models\Order;
use App\Models\OrderItem;
use App\Models\Product;
use App\Models\Province;
use App\Models\Shop;
use App\Models\Theme;
use App\Models\Ticket;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::fallback(function () {
    return response()->json([
        'message' => 'Page Not Found. If error persists, contact'
    ], 404);
});

Route::prefix('auth/user')->group(function () {
    Route::post('login/register', [UserApiAuthController::class, 'loginRegister'])->name('requestLoginRegister');
    Route::post('login/code', [UserApiAuthController::class, 'loginWithCode'])->name('loginWithCode');
    Route::post('login/pass', [UserApiAuthController::class, 'loginWithPass'])->name('loginWithPass');
    Route::post('set/pass', [UserApiAuthController::class, 'registerPass'])->name('registerPass');
    Route::post('forget/pass', [UserApiAuthController::class, 'forgetPass'])->name('forgetPass');
});
Route::prefix('auth/customer')->group(function () {
    Route::post('login/register', [CustomerApiAuthController::class, 'loginRegister'])->name('requestLoginRegister');
    Route::post('login/code', [CustomerApiAuthController::class, 'loginWithCode'])->name('loginWithCode');
});
Route::prefix('auth/admin')->group(function () {
    Route::post('login/pass', [AdminApiAuthController::class, 'loginWithPass'])->name('loginWithPass');
});

Route::middleware('auth:api_user')->get('/user', function (Request $request) {
    return $request->user();
});

Route::middleware('auth:api_user')->prefix('address')->name('address.')->group(function () {
    Route::get('/', [AddressController::class, 'index'])->name('index')->can('index', Address::class);
    Route::post('/', [AddressController::class, 'store'])->name('store')->can('create', Address::class);
    Route::get('/{address}', [AddressController::class, 'show'])->name('show')->can('view', 'address');
    Route::patch('/{address}', [AddressController::class, 'update'])->name('update')->can('update', 'address');
    Route::delete('/{address}', [AddressController::class, 'destroy'])->name('destroy')->can('delete', 'address');
});

Route::middleware('auth:api_user')->prefix('articleCategory')->name('articleCategory.')->group(function () {
    Route::get('/', [ArticleCategoryController::class, 'index'])->name('index')->can('index', ArticleCategory::class);
    Route::post('/', [ArticleCategoryController::class, 'store'])->name('store')->can('create', ArticleCategory::class);
    Route::get('/{articleCategory}', [ArticleCategoryController::class, 'show'])->name('show')->can('view', 'articleCategory');
    Route::patch('/{articleCategory}', [ArticleCategoryController::class, 'update'])->name('update')->can('update', 'articleCategory');
    Route::delete('/{articleCategory}', [ArticleCategoryController::class, 'destroy'])->name('destroy')->can('delete', 'articleCategory');
});

Route::middleware('auth:api_user')->prefix('article')->name('article.')->group(function () {
    Route::get('/', [ArticleController::class, 'index'])->name('index')->can('index', Article::class);
    Route::post('/', [ArticleController::class, 'store'])->name('store')->can('create', Article::class);
    Route::get('/{article}', [ArticleController::class, 'show'])->name('show')->can('view', 'article');
    Route::patch('/{article}', [ArticleController::class, 'update'])->name('update')->can('update', 'article');
    Route::delete('/{article}', [ArticleController::class, 'destroy'])->name('destroy')->can('delete', 'article');
});

Route::middleware('auth:api_user')->prefix('category')->name('category.')->group(function () {
    Route::get('/', [CategoryController::class, 'index'])->name('index')->can('index', Category::class);
    Route::post('/', [CategoryController::class, 'store'])->name('store')->can('create', Category::class);
    Route::get('/{category}', [CategoryController::class, 'show'])->name('show')->can('view', 'category');
    Route::patch('/{category}', [CategoryController::class, 'update'])->name('update')->can('update', 'category');
    Route::delete('/{category}', [CategoryController::class, 'destroy'])->name('destroy')->can('delete', 'category');
});

Route::middleware('auth:api_user')->prefix('city')->name('city.')->group(function () {
    Route::get('/', [CityController::class, 'index'])->name('index')->can('index', City::class);
});

Route::middleware('auth:api_user')->prefix('province')->name('province.')->group(function () {
    Route::get('/', [ProvinceController::class, 'index'])->name('index')->can('index', Province::class);
});

Route::middleware('auth:api_user')->prefix('comment')->name('comment.')->group(function () {
    Route::get('/', [CommentController::class, 'index'])->name('index')->can('index', Comment::class);
    Route::post('/', [CommentController::class, 'store'])->name('store')->can('create', Comment::class);
    Route::get('/{comment}', [CommentController::class, 'show'])->name('show')->can('view', 'comment');
    Route::delete('/{comment}', [CommentController::class, 'destroy'])->name('destroy')->can('delete', 'comment');
});

Route::middleware('auth:api_user')->prefix('customer')->name('customer.')->group(function () {
    Route::get('/', [CustomerController::class, 'index'])->name('index')->can('index', Customer::class);
    Route::get('/{customer}', [CustomerController::class, 'show'])->name('show')->can('view', 'customer');
    Route::patch('/{customer}', [CustomerController::class, 'update'])->name('update')->can('update', 'customer');
});

Route::middleware('auth:api_user')->prefix('discount')->name('discount.')->group(function () {
    Route::get('/', [DiscountController::class, 'index'])->name('index')->can('index', Discount::class);
    Route::post('/', [DiscountController::class, 'store'])->name('store')->can('create', Discount::class);
    Route::get('/{discount}', [DiscountController::class, 'show'])->name('show')->can('view', 'discount');
    Route::patch('/{discount}', [DiscountController::class, 'update'])->name('update')->can('update', 'discount');
    Route::delete('/{discount}', [DiscountController::class, 'destroy'])->name('destroy')->can('delete', 'discount');
});

Route::middleware('auth:api_user')->prefix('domain')->name('domain.')->group(function () {
    Route::get('/', [DomainController::class, 'index'])->name('index')->can('index', Domain::class);
    Route::post('/', [DomainController::class, 'store'])->name('store')->can('create', Domain::class);
    Route::get('/{domain}', [DomainController::class, 'show'])->name('show')->can('view', 'domain');
    Route::patch('/{domain}', [DomainController::class, 'update'])->name('update')->can('update', 'domain');
    Route::delete('/{domain}', [DomainController::class, 'destroy'])->name('destroy')->can('delete', 'domain');
});

Route::middleware('auth:api_user')->prefix('gallery')->name('gallery.')->group(function () {
    Route::get('/', [GalleryController::class, 'index'])->name('index')->can('index', Gallery::class);
    Route::post('/', [GalleryController::class, 'store'])->name('store')->can('create', Gallery::class);
    Route::get('/{gallery}', [GalleryController::class, 'show'])->name('show')->can('view', 'gallery');
    Route::delete('/{gallery}', [GalleryController::class, 'destroy'])->name('destroy')->can('delete', 'gallery');
});

Route::middleware('auth:api_user')->prefix('option')->name('option.')->group(function () {
    Route::get('/{product}', [OptionController::class, 'index'])->name('index')->can('index', [Option::class, 'product']);
    Route::post('/', [OptionController::class, 'store'])->name('store')->can('create', Option::class);
    Route::patch('/{option}', [OptionController::class, 'update'])->name('update')->can('update', 'option');
    Route::delete('/{option}', [OptionController::class, 'destroy'])->name('destroy')->can('delete', 'option');
});

Route::middleware('auth:api_user')->prefix('order')->name('order.')->group(function () {
    Route::get('/', [OrderController::class, 'index'])->name('index')->can('index', Order::class);
    Route::post('/', [OrderController::class, 'store'])->name('store')->can('create', Order::class);
    Route::get('/{order}', [OrderController::class, 'show'])->name('show')->can('view', 'order');
    Route::patch('/{order}', [OrderController::class, 'update'])->name('update')->can('update', 'order');
    Route::delete('/{order}', [OrderController::class, 'destroy'])->name('destroy')->can('delete', 'order');
});

Route::middleware('auth:api_user')->prefix('product')->name('product.')->group(function () {
    Route::get('/', [ProductController::class, 'index'])->name('index')->can('index', Product::class);
    Route::post('/', [ProductController::class, 'store'])->name('store')->can('create', Product::class);
    Route::get('/{product}', [ProductController::class, 'show'])->name('show')->can('view', 'product');
    Route::patch('/{product}', [ProductController::class, 'update'])->name('update')->can('update', 'product');
    Route::delete('/{product}', [ProductController::class, 'destroy'])->name('destroy')->can('delete', 'product');
});

Route::middleware('auth:api_user')->prefix('shop')->name('shop.')->group(function () {
    Route::get('/', [ShopController::class, 'index'])->name('index')->can('index', Shop::class);
    Route::post('/', [ShopController::class, 'store'])->name('store')->can('create', Shop::class);
    Route::get('/{shop}', [ShopController::class, 'show'])->name('show')->can('view', 'shop');
    Route::patch('/{shop}', [ShopController::class, 'update'])->name('update')->can('update', 'shop');
    Route::delete('/{shop}', [ShopController::class, 'destroy'])->name('destroy')->can('delete', 'shop');
});

Route::middleware('auth:api_user')->prefix('theme')->name('theme.')->group(function () {
    Route::get('/', [ThemeController::class, 'index'])->name('index')->can('index', Theme::class);
    Route::get('/{theme}', [ThemeController::class, 'show'])->name('show')->can('view', 'theme');
});

Route::middleware('auth:api_user')->prefix('ticket')->name('ticket.')->group(function () {
    Route::get('/', [TicketController::class, 'index'])->name('index')->can('index', Ticket::class);
    Route::post('/', [TicketController::class, 'store'])->name('store')->can('create', Ticket::class);
    Route::get('/{ticket}', [TicketController::class, 'show'])->name('show')->can('view', 'ticket');
    Route::patch('/{ticket}', [TicketController::class, 'update'])->name('update')->can('update', 'ticket');
    Route::delete('/{ticket}', [TicketController::class, 'destroy'])->name('destroy')->can('delete', 'ticket');
});


Route::middleware('auth:api_customer')->prefix('customer')->name('customer.')->group(function () {
    Route::prefix('order')->name('order.')->group(function () {
        Route::get('/', [OrderController::class, 'customerIndex'])->name('customer.index')->can('customerIndex', Order::class);
        Route::post('/', [OrderController::class, 'customerStore'])->name('customer.store')->can('customerCreate', Order::class);
        Route::get('/{order}', [OrderController::class, 'customerShow'])->name('customer.show')->can('customerView', 'order');
    });
});