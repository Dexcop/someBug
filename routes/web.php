<?php

use App\Http\Controllers\DataController;
use App\Http\Controllers\InvoiceController;
use App\Http\Controllers\LoginController;
use App\Http\Controllers\RegisterController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return redirect('/register');
});

Route::get('/register', [RegisterController::class, 'index'])->name('register')->middleware('guest');
Route::post('/register', [RegisterController::class, 'register']);

Route::get('/dashboard', [LoginController::class, 'dashboard'])->name('dashboard')->middleware('auth', 'refresh.session');
Route::get('/admin_dashboard', [LoginController::class, 'adminDashboard'])->middleware('auth', 'is_admin', 'refresh.session');

Route::get('/store', [LoginController::class, 'storeDashboard'])->middleware('auth', 'is_admin');
Route::post('/admin_dashboard', [DataController::class, 'store']);

Route::get('/edit/{id}', [DataController::class, 'edit'])->middleware('auth', 'is_admin');
Route::patch('/update/{id}', [DataController::class, 'update']);
Route::delete('/delete/{id}', [DataController::class, 'delete']);

Route::get('/login', [LoginController::class, 'index'])->name('login')->middleware('guest');
Route::post('/login', [LoginController::class, 'authenticate']);

Route::post('/logout', [LoginController::class, 'logout']);

Route::get('/cart/{id}', [DataController::class, 'viewCart'])->middleware('auth');
// Route::post('/buy/{id}', [DataController::class, 'buy']);
Route::post('/buy/{id}', [DataController::class, 'buy'])->name('buy.confirmation');
Route::get('/buy/confirmation/{id}', [InvoiceController::class, 'confirmation'])->name('purchase.confirmation')->middleware('auth');
Route::get('/purchase/complete'/* , [InvoiceController::class, 'complete'] */)->name('purchase.complete')->middleware('auth');
Route::post('/invoice/create', [InvoiceController::class, 'complete'])->name('purchased');