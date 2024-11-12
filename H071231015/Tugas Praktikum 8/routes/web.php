<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\MainController;

Route::get('/', [MainController::class, 'index'] )->name('home');

Route::get('/about', [MainController::class, 'about'])->name('about');

Route::get('/contact', [MainController::class, 'contact'])->name('contact');

Route::post('/contact', [MainController::class, 'submitContact']) ->name('submit.contact');


// Route::get('/master', function() {
//     return view('layouts.master');
// });