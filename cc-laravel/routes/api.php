<?php

use App\Http\Controllers\Api\Admin\ProductController;
use App\Http\Controllers\Api\Admin\StockController;
use App\Http\Controllers\Api\Admin\Auth\LoginController;
use App\Http\Controllers\Api\Admin\UserController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "api" middleware group. Make something great!
|
*/

Route::middleware(['guest'])->group(function ($router) {
    $router->post('login', [LoginController::class, 'login']);
    $router->post('users', [UserController::class, 'store']);
    $router->post('product', [ProductController::class, 'store']);
    $router->get('product', [ProductController::class, 'index']);
    $router->post('stock', [StockController::class, 'store']);
});

Route::middleware(['auth:sanctum'])->group(function ($router) {
    $router->post('logout', [LoginController::class, 'logout']);
    
    $router->resource('users', UserController::class)
        ->only(['index', 'show', 'update', 'destroy'])
        ->parameters([
            'users' => 'user'
        ]);
});