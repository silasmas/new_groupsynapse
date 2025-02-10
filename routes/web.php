<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\CartController;
use App\Http\Controllers\FavoriteController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\ProfileController;

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

Route::get('/', [HomeController::class,'index'])->name('home');
Route::get('about', [HomeController::class,'about'])->name('about');
Route::get('branches', [HomeController::class,'branches'])->name('branches');
Route::get('shop', [HomeController::class,'shop'])->name('shop');
Route::get('contact', [HomeController::class,'contact'])->name('contact');
Route::get('showProduct/{slug}', [HomeController::class,'show'])->name('showProduct');

Route::get('favories', [HomeController::class,'favories'])->name('favories');

Route::middleware(['auth'])->group(function () {

    Route::get('addFavorie/{id}', [FavoriteController::class,'addFavorite'])->name('addFavorie');
    Route::get('/favorit/details', [FavoriteController::class, 'getFavorites'])->name('favorit.details');
    Route::get('removeFavorie/{id}', [FavoriteController::class,'removeFavorite'])->name('removeFavorie');
    Route::get('/favorie/update-block/{id}', [FavoriteController::class, 'updateProductBlock'])->name('favorie.updateBlock');

    Route::get('/cart', [CartController::class, 'index'])->name('cart');
    Route::get('/cart/add/{id}/{qty}', [CartController::class, 'addToCart'])->name('cart.add');
    Route::get('/cart/details', [CartController::class, 'details'])->name('cart.details');
    Route::get("/cart/update/{id}/{qty}/{type}", [CartController::class,"updateCart"])->name('cart.update');
    Route::get("/cart/remove/{id}", [CartController::class,"removeFromCart"])->name('cart.remove');

    Route::get("/checkout", [CartController::class,"commnder"])->name('checkout');

});

Route::get('/dashboard', function () {
    return redirect()->route('home');
    // return view('pages.home');
})->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

require __DIR__.'/auth.php';
