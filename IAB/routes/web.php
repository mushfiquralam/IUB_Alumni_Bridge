<?php

use App\Http\Controllers\indexController;
use Illuminate\Support\Facades\Route;


Route::get('/', [indexController::class, 'index'])->name('index');
Route::get('/forgotPassword', [indexController::class, 'forgotPassword']);
Route::get('/signup', [indexController::class, 'signup'])->name('signup');
Route::post('/store', [indexController::class, 'store'])->name('alumni.store');

