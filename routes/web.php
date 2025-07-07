<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\RecipeController;
use App\Http\Controllers\CartController;
use App\Http\Controllers\ReviewController;
use App\Http\Controllers\OrderController;

// Public routes
Route::get('/', [HomeController::class, 'index'])->name('home');
Route::get('/about', [HomeController::class, 'about'])->name('about');
Route::get('/recipes', [HomeController::class, 'recipes'])->name('recipes.index');
Route::get('/recipes/{recipe}', [RecipeController::class, 'show'])->name('recipes.show');

// Cart routes
Route::prefix('cart')->group(function () {
    Route::get('/', [CartController::class, 'index'])->name('cart.index');
    // Route::post('/recipes/{recipe}/add', [CartController::class, 'add'])->name('recipes.add-to-cart');
    Route::post('/recipes/add', [CartController::class, 'add'])->name('recipes.add-to-cart');
    Route::patch('/items/{item}', [CartController::class, 'update'])->name('cart.update');
    Route::delete('/items/{item}', [CartController::class, 'remove'])->name('cart.remove');
    Route::get('/checkout', [CartController::class, 'checkout'])->name('cart.checkout');
});

// Review routes
Route::post('/recipes/{recipe}/reviews', [ReviewController::class, 'store'])->name('reviews.store');

// Order routes
Route::post('/orders', [OrderController::class, 'store'])->name('orders.store');
Route::get('/orders/{order}/confirmation', [OrderController::class, 'confirmation'])->name('order.confirmation');

// Authentication routes
Auth::routes();


Route::prefix('admin')->as('admin.')->middleware(['auth'])->group(function () {
    Route::get('/dashboard', [App\Http\Controllers\Admin\AdminController::class, 'dashboard'])->name('dashboard');
    
    // Recipes
    Route::resource('recipes', App\Http\Controllers\Admin\RecipeController::class)->except(['show']);
    
    // Ingredients
    Route::resource('ingredients', App\Http\Controllers\Admin\IngredientController::class)->except(['show']);
    
    // Users
    Route::resource('users', App\Http\Controllers\Admin\UserController::class);
    
    // Reviews
    Route::get('/reviews', [App\Http\Controllers\Admin\ReviewController::class, 'index'])->name('reviews.index');
    Route::delete('/reviews/{review}', [App\Http\Controllers\Admin\ReviewController::class, 'destroy'])->name('reviews.destroy');
    
    // Orders
    Route::get('/orders', [App\Http\Controllers\Admin\OrderController::class, 'index'])->name('orders.index');
    Route::get('/orders/{order}', [App\Http\Controllers\Admin\OrderController::class, 'show'])->name('orders.show');
    Route::put('/orders/{order}', [App\Http\Controllers\Admin\OrderController::class, 'update'])->name('orders.update');
    
    // Settings
    Route::get('/settings', [App\Http\Controllers\Admin\CompanySettingController::class, 'edit'])->name('settings.edit');
    Route::put('/settings', [App\Http\Controllers\Admin\CompanySettingController::class, 'update'])->name('settings.update');
});