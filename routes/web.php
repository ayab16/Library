<?php

use App\Http\Controllers\authorController;
use App\Http\Controllers\BookCheckinController;
use App\Http\Controllers\BookcheckoutController;
use App\Http\Controllers\BookController;
use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;

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

Route::post('/books', [BookController::class, 'store'])->name('home');

Route::patch('/books/{book}', [BookController::class, 'update'])->name('bookPage');

Route::delete('/books/{book}', [BookController::class, 'destroy']);

Route::post('/author', [authorController::class, 'store'])->name('storeAuthor');

Route::post('/checkout/{book}', [BookcheckoutController::class, 'store']);

Route::post('/checkin/{book}', [BookCheckinController::class, 'store']);

Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

require __DIR__.'/auth.php';
