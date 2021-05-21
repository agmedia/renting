<?php

use App\Http\Controllers\Back\Catalog\AuthorController;
use App\Http\Controllers\Back\Catalog\CategoryController;
use App\Http\Controllers\Back\Catalog\ProductController;
use App\Http\Controllers\Back\Catalog\PublisherController;
use App\Http\Controllers\Back\OrderController;
use App\Http\Controllers\Back\Settings\QuickMenuController;
use App\Http\Controllers\Back\Settings\SettingsController;
use App\Http\Controllers\Back\UserController;
use App\Http\Controllers\Front\HomeController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/
/**
 * FRONT ROUTES
 */
Route::get('/', [HomeController::class, 'index'])->name('index');

Route::get('/kategorija', function() { return view('front.category.index'); })->name('kategorija');

Route::get('/knjiga', function() { return view('front.product.index'); })->name('knjiga');

Route::get('/autori', function() { return view('front.authors.index'); })->name('autori');

Route::get('/nakladnici', function() { return view('front.publishers.index'); })->name('nakladnici');

Route::get('/kosarica', function() { return view('front.checkout.cart'); })->name('kosarica');

Route::get('/adresa-isporuke', function() { return view('front.checkout.podaci'); })->name('adresa-isporuke');

/**
 * BACK ROUTES
 */
Route::middleware(['auth:sanctum', 'verified'])->prefix('admin')->group(function () {
    Route::match(['get', 'post'], '/dashboard', function() { return view('back.dashboard'); })->name('dashboard');

    // CATALOG
    Route::prefix('catalog')->group(function () {
        // KATEGORIJE
        Route::get('categories', [CategoryController::class, 'index'])->name('categories');
        Route::get('category/create', [CategoryController::class, 'create'])->name('category.create');
        Route::post('category', [CategoryController::class, 'store'])->name('category.store');
        Route::get('category/{category}/edit', [CategoryController::class, 'edit'])->name('category.edit');
        Route::patch('category/{category}', [CategoryController::class, 'update'])->name('category.update');

        // IZDAVAČI
        Route::get('publishers', [PublisherController::class, 'index'])->name('publishers');
        Route::get('publisher/create', [PublisherController::class, 'create'])->name('publishers.create');
        Route::post('publisher', [PublisherController::class, 'store'])->name('publishers.store');
        Route::get('publisher/{publisher}/edit', [PublisherController::class, 'edit'])->name('publishers.edit');
        Route::patch('publisher/{publisher}', [PublisherController::class, 'update'])->name('publishers.update');

        // AUTORI
        Route::get('authors', [AuthorController::class, 'index'])->name('authors');
        Route::get('author/create', [AuthorController::class, 'create'])->name('authors.create');
        Route::post('author', [AuthorController::class, 'store'])->name('authors.store');
        Route::get('author/{author}/edit', [AuthorController::class, 'edit'])->name('authors.edit');
        Route::patch('author/{author}', [AuthorController::class, 'update'])->name('authors.update');

        // ARTIKLI
        Route::get('products', [ProductController::class, 'index'])->name('products');
        Route::get('product/create', [ProductController::class, 'create'])->name('products.create');
        Route::post('product', [ProductController::class, 'store'])->name('products.store');
        Route::get('product/{product}/edit', [ProductController::class, 'edit'])->name('products.edit');
        Route::patch('product/{product}', [ProductController::class, 'update'])->name('products.update');
    });

    // NARUDŽBE
    Route::get('orders', [OrderController::class, 'index'])->name('orders');
    Route::get('order/create', [OrderController::class, 'create'])->name('orders.create');
    Route::post('order', [OrderController::class, 'store'])->name('orders.store');
    Route::get('order/{order}/edit', [OrderController::class, 'edit'])->name('orders.edit');
    Route::patch('order/{order}', [OrderController::class, 'update'])->name('orders.update');

    // KORISNICI
    Route::get('users', [UserController::class, 'index'])->name('users');
    Route::get('user/create', [UserController::class, 'create'])->name('users.create');
    Route::post('user', [UserController::class, 'store'])->name('users.store');
    Route::get('user/{user}/edit', [UserController::class, 'edit'])->name('users.edit');
    Route::patch('user/{user}', [UserController::class, 'update'])->name('users.update');

    // POSTAVKE
    Route::prefix('settings')->group(function () {
        Route::get('/', [SettingsController::class, 'index'])->name('settings');
    });

    // SETTINGS
    Route::get('/clean/cache', [QuickMenuController::class, 'cache'])->name('cache');
    Route::get('maintenance/on', [QuickMenuController::class, 'maintenanceModeON'])->name('maintenance.on');
    Route::get('maintenance/off', [QuickMenuController::class, 'maintenanceModeOFF'])->name('maintenance.off');
});
