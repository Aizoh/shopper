<?php

declare(strict_types=1);

use App\Livewire\Pages;
use Illuminate\Support\Facades\Route;
use Livewire\Volt\Volt;
use App\Http\Controllers\LegalController;
use App\Http\Controllers\MPesaController;
use App\Http\Controllers\ProductController;
use App\Livewire\FrontCategories;
use App\Models\Product;

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

Route::get('/', Pages\Home::class)->name('home');
Route::get('/category/{slug}', FrontCategories::class)->name('front.category');
Route::get('/products/{slug}', Pages\SingleProduct::class)->name('single-product');

Route::get('search', [ProductController::class, 'searchFront'])->name('products.search');

Route::middleware('auth')->group(function (): void {
    Volt::route('/order/confirmed/{number}', 'pages.order.confirmed')
        ->name('order-confirmed');

    Route::get('checkout', Pages\Checkout::class)->name('checkout');
});

Route::prefix('blog')->group(function (): void {
    Route::get('posts', [ProductController::class, 'index'])->name('posts');
});

/*
* Legal routes
*/
Route::get('/privacy', [LegalController::class, 'privacy'])->name('legal.privacy');
Route::get('/terms-of-use', [LegalController::class, 'terms'])->name('legal.terms');
Route::get('/refund-policy', [LegalController::class, 'refund'])->name('legal.refund');
Route::get('/shipping', [LegalController::class, 'shipping'])->name('legal.shipping');
Route::get('/mpesa-callback', [MPesaController::class,'callback'])->name('mpesa.callback');

#
require __DIR__.'/auth.php';

