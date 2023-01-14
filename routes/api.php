<?php

use App\Http\Controllers\AddressController;
use App\Http\Controllers\Auth\ApiAuthController;
use App\Models\Address;
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

Route::prefix('auth')->group(function () {
    Route::post('login/register', [ApiAuthController::class, 'loginRegister'])->name('requestLoginRegister');
    Route::post('login/code', [ApiAuthController::class, 'loginWithCode'])->name('loginWithCode');
    Route::post('login/pass', [ApiAuthController::class, 'loginWithPass'])->name('loginWithPass');
    Route::post('set/pass', [ApiAuthController::class, 'registerPass'])->name('registerPass');
    Route::post('forget/pass', [ApiAuthController::class, 'forgetPass'])->name('forgetPass');
});

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});
Route::middleware('auth:sanctum')->prefix('address')->name('address.')->group(function () {
    Route::get('/', [AddressController::class, 'index'])->name('index')->can('viewAny', Address::class);
    Route::post('/', [AddressController::class, 'store'])->name('store')->can('create', Address::class);
    Route::get('/{address}', [AddressController::class, 'show'])->name('show')->can('view', 'address');
    Route::patch('/{address}', [AddressController::class, 'update'])->name('update')->can('update', 'address');
    Route::delete('/{address}', [AddressController::class, 'destroy'])->name('destroy')->can('delete', 'address');
});


Route::fallback(function () {
    return response()->json([
        'message' => 'Page Not Found. If error persists, contact'
    ], 404);
});