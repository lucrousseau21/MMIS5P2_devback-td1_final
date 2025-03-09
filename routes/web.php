<?php

use App\Http\Controllers\AddressController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\RemovePanierItemController;
use App\Http\Controllers\ShowAllCategoriesController;
use App\Http\Controllers\ShowAllProductsController;
use App\Http\Controllers\ShowOneProduct;
use App\Http\Controllers\ShowOneCategory;
use App\Http\Controllers\ShowPanier;
use App\Http\Controllers\AddToPanierController;
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\ShowPanierController;
use App\Http\Controllers\OrderController;
use App\Http\Controllers\PanierController;
use App\Http\Controllers\ProductController;
use Illuminate\Foundation\Application;
use Illuminate\Support\Facades\Route;
use Inertia\Inertia;

// Route::get('/', function () {
//     return Inertia::render('Welcome', [
//         'canLogin' => Route::has('login'),
//         'canRegister' => Route::has('register'),
//         'laravelVersion' => Application::VERSION,
//         'phpVersion' => PHP_VERSION,
//     ]);
// });

Route::get('/', HomeController::class)->name('home');

Route::get('/categories', [CategoryController::class, 'index'])->name('categories');
// Route::get('/categories/{id}', [CategoryController::class, 'show'])->name('categories.show');
Route::get('/categories/{slug}', [CategoryController::class, 'show'])->name('categories.show');

Route::get('/products', [ProductController::class, 'index'])->name('products');
Route::get('/products/{product}', [ProductController::class, 'show'])->name('products.show');

Route::middleware([
    'auth:sanctum',
    config('jetstream.auth_session'),
    'verified',
])->group(function () {
    Route::get('/dashboard', function () {
        return Inertia::render('Dashboard');
    })->name('dashboard');

    Route::get('/panier', [PanierController::class, 'show'])->name('panier');
    Route::post('/panier/add/{product}', [PanierController::class, 'add'])->name('panier.add');
    Route::delete('/panier/remove/{cartItem}', [PanierController::class, 'remove'])->name('panierItems.remove');
    Route::patch('panier-items/{id}/quantity', [PanierController::class, 'updateQuantity'])->name('panierItems.updateQuantity');

    Route::post('/orders', [OrderController::class, 'store'])->name('orders.store');
    Route::get('/orders', [OrderController::class, 'index'])->name('orders.index');
    Route::get('/order/{order}', [OrderController::class, 'show'])->name('orders.show');

    Route::post('/addresses', [AddressController::class, 'store'])->name('addresses.store');
    Route::post('/addresses/{id}/default', [AddressController::class, 'setDefault'])->name('addresses.setDefault');
    Route::get('/addresses', [AddressController::class, 'index'])->name('addresses.index');
    Route::post('/addresses', [AddressController::class, 'store'])->name('addresses.store');
    Route::post('/addresses/{id}/default', [AddressController::class, 'setDefault'])->name('addresses.setDefault');
});
