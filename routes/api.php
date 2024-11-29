<?php

use App\Http\Controllers\Api\AuthController;
use App\Http\Controllers\Api\CategoryController;
use App\Http\Controllers\Api\VendorController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;


Route::post('login', [AuthController::class, 'login']);
Route::post('create-account', [AuthController::class, 'signup']);
Route::get('category', [CategoryController::class, 'category']);
Route::post('vendor-signup', [VendorController::class, 'store']);

Route::middleware(['auth:api'])->group(function () {
    
});