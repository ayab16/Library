<?php

use App\Http\Controllers\authorController;
use App\Http\Controllers\BookController;
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

Route::post('/books', [BookController::class, 'store'])->name('home');

Route::patch('/books/{book}', [BookController::class, 'update'])->name('bookPage');

Route::delete('/books/{book}', [BookController::class, 'destroy']);

Route::post('/author', [authorController::class, 'store'])->name('storeAuthor');
