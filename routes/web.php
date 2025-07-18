<?php

use App\Http\Controllers\CartController;
use App\Http\Controllers\CommandeController;
use App\Http\Controllers\CommentController;
use App\Http\Controllers\ContactController;
use App\Http\Controllers\FavoriteController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\NewsletterController;
use App\Http\Controllers\PaymentController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\ServiceController;
use App\Http\Controllers\ServiceUserController;
use Illuminate\Foundation\Auth\EmailVerificationRequest;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

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

Route::get('/', [HomeController::class, 'index'])->name('home');
Route::get('about', [HomeController::class, 'about'])->name('about');
Route::get('branches', [HomeController::class, 'branches'])->name('branches');
Route::get('shop', [HomeController::class, 'shop'])->name('shop');
Route::get('services', [HomeController::class, 'shop'])->name('services');
Route::get('contact', [HomeController::class, 'contact'])->name('contact');
Route::get('showProduct/{slug}', [HomeController::class, 'show'])->name('showProduct');
Route::get('showService/{slug}', [ServiceController::class, 'show'])->name('showService');
Route::get('services', [ServiceController::class, 'index'])->name('services');

Route::get('favories', [HomeController::class, 'favories'])->name('favories');
Route::post('/contact', [ContactController::class, 'store'])->name('contact.store');
// Route::get('/checkTransactionStatus', [CartController::class, 'checkTransactionStatus'])->name('checkTransactionStatus');

// routes/web.php
// routes/web.php
Route::post('{type}/{id}/comments', [CommentController::class, 'storeComment'])
    ->where('type', 'service|produit')
    ->name('comments.store');

// routes/web.php
Route::get('{type}/{id}/comments/latest', [CommentController::class, 'latestComments'])
    ->where('type', 'service|produit')
    ->name('comments.latest');
Route::get('{type}/{id}/comments/all', [CommentController::class, 'allComments'])
    ->where('type', 'service|produit')
    ->name('comments.all');

Route::post('/newsletter', [NewsletterController::class, 'subscribe'])->name('newsletter.subscribe');

use App\Http\Controllers\Auth\EmailVerificationController;

Route::get('/email/verify', [EmailVerificationController::class, 'notice'])
    ->middleware('auth')
    ->name('verification.notice');

// Route::get('/email/verify/{id}/{hash}', function (EmailVerificationController $request) {
//     if (! $request->user() || $request->user()->id != $request->route('id')) {
//         abort(403); // protection renforcée
//     }

//     if (! $request->user()->hasVerifiedEmail()) {
//         $request->fulfill();
//     }

//     return redirect()->route('verification.success');
// })->middleware(['auth', 'signed'])->name('verification.verify');

Route::get('/email/verify/{id}/{hash}', [EmailVerificationController::class, 'verify'])
    ->middleware(['auth', 'signed'])
    ->name('verification.verify');

Route::get('/email/verified/success', function () {
    return view('auth.email-verified');
})->name('verification.success');


Route::post('/email/verification-notification', function (Request $request) {
    $request->user()->sendEmailVerificationNotification();

    return back()->with('status', 'verification-link-sent');
})->middleware(['auth', 'throttle:6,1'])->name('verification.send');



Route::middleware(['auth', 'verified'])->group(function () {

    Route::get('addFavorie/{id}', [FavoriteController::class, 'addFavorite'])->name('addFavorie');
    Route::get('/favorit/details', [FavoriteController::class, 'getFavorites'])->name('favorit.details');
    Route::get('removeFavorie/{id}', [FavoriteController::class, 'removeFavorite'])->name('removeFavorie');
    Route::get('/favorie/update-block/{id}', [FavoriteController::class, 'updateProductBlock'])->name('favorie.updateBlock');

    Route::get('getService/{slug}', [ServiceUserController::class, 'getService'])->name('getService');

    Route::get('/cart', [CartController::class, 'index'])->name('cart');
    Route::get('/cart/add/{id}/{qty}', [CartController::class, 'addToCart'])->name('cart.add');
    Route::get('/cart/details', [CartController::class, 'details'])->name('cart.details');
    Route::get("/cart/update/{id}/{qty}/{type}", [CartController::class, "updateCart"])->name('cart.update');
    Route::get("/cart/remove/{id}", [CartController::class, "removeFromCart"])->name('cart.remove');

    Route::get("/checkout", [CartController::class, "checkout"])->name('checkout');
    Route::get('/checkTransactionStatus', [CartController::class, 'checkTransactionStatus'])->name('checkTransactionStatus');
    // Route::post("/caisse", [PaymentController::class, 'initiatePayment'])->name('caisse');
    Route::post("/caisse", [CartController::class, "createOrder"])->name('caisse');
    Route::post("/caisseService", [CartController::class, "createOrderService"])->name('caisseService');

    Route::post('/payment/initiate', [PaymentController::class, 'initiatePayment']);
    Route::post('/payment/status', [PaymentController::class, 'checkPaymentStatus']);
    Route::post('/payment/callback', [PaymentController::class, 'paymentCallback'])->name('payment.callback');

    Route::post('/init-service', [ServiceUserController::class, 'init'])->name('init.service');
    Route::post('/init.recharge', [ServiceUserController::class, 'initrecharge'])->name('init.recharge');
    Route::post('/edit-service', [ServiceUserController::class, 'modifier'])->name('edit.service');

    Route::post('/logTransactionAttempt', [ServiceUserController::class, 'store']);

    Route::get('/profil', [CartController::class, 'commandeStatus'])->name('profil');
    Route::patch('/editProfil', [CartController::class, 'commandeStatus'])->name('editProfil');
    Route::get('/Updateprofil', [CartController::class, 'commandeStatus'])->name('Updateprofil');

    Route::get('/mesAchats', [CommandeController::class, 'mesAchats'])->name('mesAchats');

});

Route::get('/paid/{reference}/{amount}/{currency}/{code}', [CartController::class, 'paid'])->whereNumber(['amount'])->name('paid');
Route::get('/commandeStatus', [CartController::class, 'commandeStatus'])->name('commandeStatus');

Route::get('/dashboard', function () {
    return redirect()->route('home');
    // return view('pages.home');
})->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});
Route::get('/symlink', action: function () {
    return view('symlink');
})->name('generate_symlink');
require __DIR__ . '/auth.php';
