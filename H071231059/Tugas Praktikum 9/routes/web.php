<?php

use App\Http\Controllers\CategoryController;
use App\Http\Controllers\InventoryLogController;
use App\Http\Controllers\ProductController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});

Route::resource('/category', CategoryController::class);
Route::resource('/product', ProductController::class);
Route::resource('/inventorylog', InventoryLogController::class);


