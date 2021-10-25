<?php

use App\Http\Controllers\Auth\AuthenticatedSessionController;
use App\Http\Controllers\ContactsController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\ImagesController;
use App\Http\Controllers\InventoriesController;
use App\Http\Controllers\OrganizationsController;
use App\Http\Controllers\ProductsController;
use App\Http\Controllers\ReportsController;
use App\Http\Controllers\UsersController;
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

// Auth

Route::get('login', [AuthenticatedSessionController::class, 'create'])
    ->name('login')
    ->middleware('guest');

Route::post('login', [AuthenticatedSessionController::class, 'store'])
    ->name('login.store')
    ->middleware('guest');

Route::delete('logout', [AuthenticatedSessionController::class, 'destroy'])
    ->name('logout');

// Dashboard

Route::get('/', [DashboardController::class, 'index'])
    ->name('dashboard')
    ->middleware('auth');

// Users

Route::get('users', [UsersController::class, 'index'])
    ->name('users')
    ->middleware('auth');

Route::get('users/create', [UsersController::class, 'create'])
    ->name('users.create')
    ->middleware('auth');

Route::post('users', [UsersController::class, 'store'])
    ->name('users.store')
    ->middleware('auth');

Route::get('users/{user}/edit', [UsersController::class, 'edit'])
    ->name('users.edit')
    ->middleware('auth');

Route::put('users/{user}', [UsersController::class, 'update'])
    ->name('users.update')
    ->middleware('auth');

Route::delete('users/{user}', [UsersController::class, 'destroy'])
    ->name('users.destroy')
    ->middleware('auth');

Route::put('users/{user}/restore', [UsersController::class, 'restore'])
    ->name('users.restore')
    ->middleware('auth');

// Images

Route::get('/img/{path}', [ImagesController::class, 'show'])
    ->where('path', '.*')
    ->name('image');

// Products

Route::get('products', [ProductsController::class, 'index'])
    ->name('products')
    ->middleware('auth');

Route::get('products/create', [ProductsController::class, 'create'])
    ->name('products.create')
    ->middleware('auth');

Route::post('products', [ProductsController::class, 'save'])
    ->name('products.save')
    ->middleware('auth');

Route::get('products/{product}/edit', [ProductsController::class, 'edit'])
    ->name('products.edit')
    ->middleware('auth');

Route::put('products/{product}', [ProductsController::class, 'update'])
    ->name('products.update')
    ->middleware('auth');

Route::delete('products/{product}', [ProductsController::class, 'delete'])
    ->name('products.delete')
    ->middleware('auth');

// Inventories

Route::get('inventory', [InventoriesController::class, 'index'])
    ->name('inventory')
    ->middleware('auth');

// Orders
Route::get('orders', [\App\Http\Controllers\OrdersController::class, 'index'])
    ->name('orders')
    ->middleware('auth');
