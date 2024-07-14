<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\UserController;
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\ChartController;
use App\Http\Controllers\ProductController;
/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

Route::get('/', function () {
    return view('welcome');
});
//auth
Route::middleware('auth')->group(function () {
});
Route::get('/register', function () {
    return view('register'); // Renders resources/views/register.blade.php
});
Route::get('/login', function () {
    return view('login'); // Renders resources/views/login.blade.php
});
//productmanagement
Route::get('/products', function () {
    return view('products'); // Renders resources/views/login.blade.php
});
//adminindex
Route::get('/admin', function () {
    return view('adminindex');

});
// routes/web.php
//charts

Route::get('/chart', [ChartController::class, 'index']);

/// routes/web.php



Route::get('/products/exportExcel', [ProductController::class, 'exportExcel'])->name('products.exportExcel');


//usermanagement
Route::get('/users', [UserController::class, 'index'])->name('users.index');
Route::get('/users', [UserController::class, 'index'])->name('users.index');
Route::get('/users/create', [UserController::class, 'create'])->name('users.create');
Route::post('/users', [UserController::class, 'store'])->name('users.store');
Route::get('/users/{id}/edit', [UserController::class, 'edit'])->name('users.edit');
Route::put('/users/{id}', [UserController::class, 'update'])->name('users.update');
Route::delete('/users/{id}', [UserController::class, 'destroy'])->name('users.destroy');

Route::get('/category', function() {
    return view('categories.categoryindex');
});


