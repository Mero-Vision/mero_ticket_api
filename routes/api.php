<?php

use App\Http\Controllers\Api\AuthController;
use App\Http\Controllers\Api\CategoryController;
use App\Http\Controllers\Api\EventController;
use App\Http\Controllers\Api\UserTicketController;
use App\Http\Controllers\Api\VendorController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;


Route::post('login', [AuthController::class, 'login']);
Route::post('create-account', [AuthController::class, 'signup']);
Route::get('category', [CategoryController::class, 'category']);
Route::post('vendor-signup', [VendorController::class, 'store']);

Route::middleware(['auth:api'])->group(function () {

    Route::get('vendors', [VendorController::class, 'index']);

    Route::get('my-events', [EventController::class, 'index']);
    Route::get('event', [EventController::class, 'homePageEvent']);
    Route::get('event/{id}', [EventController::class, 'show']);
    Route::post('event', [EventController::class, 'store']);

    Route::get('my-ticket', [UserTicketController::class, 'index']);
    Route::post('user-ticket', [UserTicketController::class, 'store']);

    Route::get('check-ticket/{id}', [UserTicketController::class, 'show']);
});