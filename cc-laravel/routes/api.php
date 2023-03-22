<?php

use App\Http\Controllers\Api\Admin\ProductController;
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
    $router->post('product', [ProductController::class, 'store']);
});

Route::middleware(['auth:sanctum'])->group(function ($router) {
    $router->get('token', [LoginController::class, 'token']);
    $router->post('logout', [LoginController::class, 'logout']);
    $router->get('users', [UserController::class, 'index']);
    $router->post('users', [UserController::class, 'store']);
});


