<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\IndexController;
use App\Http\Controllers\ListingController;
use App\Http\Controllers\ListingOfferController;
use App\Http\Controllers\RealtorListingController;
use App\Http\Controllers\RealtorListingImageController;
use App\Http\Controllers\UserAccountController;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

Route::get('/', [IndexController::class, 'index']);
Route::get('/hello', [IndexController::class, 'show'])->middleware('auth');

Route::resource('listing', ListingController::class)
    ->only(['index', 'show']);

Route::get('/login', [AuthController::class, 'create'])->name('login');
Route::post('/login', [AuthController::class, 'store'])->name('login.store');
Route::delete('/logout', [AuthController::class, 'destroy'])->name('logout');

Route::resource('/user-account', UserAccountController::class)
    ->middleware('auth')
    ->only(['create', 'store']);

Route::resource('/listing.offer', ListingOfferController::class)
    ->only(['store']);

Route::prefix('realtor')
    ->name('realtor.')
    ->middleware('auth')
    ->group(function() {
        Route::name('listing.restore')
            ->put(
                'listing/{listing}/restore',
                [RealtorListingController::class, 'restore']
            )->withTrashed();
        Route::resource('listing', RealtorListingController::class)
        ->only(['index', 'destroy', 'update', 'edit', 'create', 'store'])
        ->withTrashed();

        Route::resource('listing.image', RealtorListingImageController::class)
        ->only(['create', 'store', 'destroy']);
    });