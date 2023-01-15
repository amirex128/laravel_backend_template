<?php

use App\Http\Controllers\AddressController;
use App\Http\Controllers\AdminApiAuthController;
use App\Http\Controllers\CustomerApiAuthController;
use App\Http\Controllers\GalleryController;
use App\Http\Controllers\UserApiAuthController;
use App\Models\Address;
use App\Models\Gallery;
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

Route::middleware('auth:api_admin')->get('/user', function (Request $request) {
    return $request->user();
});

Route::middleware('auth:api_user')->prefix('address')->name('address.')->group(function () {
    Route::get('/', [AddressController::class, 'index'])->name('index')->can('viewAny', Address::class);
    Route::post('/', [AddressController::class, 'store'])->name('store')->can('create', Address::class);
    Route::get('/{address}', [AddressController::class, 'show'])->name('show')->can('view', 'address');
    Route::patch('/{address}', [AddressController::class, 'update'])->name('update')->can('update', 'address');
    Route::delete('/{address}', [AddressController::class, 'destroy'])->name('destroy')->can('delete', 'address');
});

Route::middleware('auth:api_user')->prefix('gallery')->name('gallery.')->group(function () {
    Route::get('/', [GalleryController::class, 'index'])->name('index')->can('viewAny', Gallery::class);
    Route::post('/', [GalleryController::class, 'store'])->name('store')->can('create', Gallery::class);
    Route::get('/{gallery}', [GalleryController::class, 'show'])->name('show')->can('view', 'gallery');
    Route::delete('/{gallery}', [GalleryController::class, 'destroy'])->name('destroy')->can('delete', 'gallery');
});
