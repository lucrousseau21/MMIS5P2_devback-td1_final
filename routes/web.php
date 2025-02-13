<?php

use App\Http\Controllers\HomeController;
use App\Http\Controllers\ShowAllCategoriesController;
use App\Http\Controllers\ShowAllProductsController;
use App\Http\Controllers\ShowOneProduct;
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

Route::get('/categories', ShowAllCategoriesController::class)->name('categories');

Route::get('/products', ShowAllProductsController::class)->name('products');
Route::get('/products/{product}', ShowOneProduct::class)->name('products.show');



Route::middleware([
    'auth:sanctum',
    config('jetstream.auth_session'),
    'verified',
])->group(function () {
    Route::get('/dashboard', function () {
        return Inertia::render('Dashboard');
    })->name('dashboard');
});
