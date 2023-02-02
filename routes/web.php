<?php

use App\Http\Controllers\CategoryController;
use App\Http\Controllers\CategorySortController;
use App\Http\Controllers\ProfileController;
use Illuminate\Foundation\Application;
use Illuminate\Support\Facades\Route;
use Inertia\Inertia;

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

Route::get('/', function () {
    return Inertia::render('Welcome', [
        'canLogin' => Route::has('login'),
        'canRegister' => Route::has('register'),
        'laravelVersion' => Application::VERSION,
        'phpVersion' => PHP_VERSION,
    ]);
});

Route::get('/dashboard', function () {
    return Inertia::render('Dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');



Route::get('/category', [CategoryController::class, 'index'])->middleware('auth')->name('category');
Route::post('/category', [CategoryController::class, 'store'])->middleware('auth')->name('category.create');
Route::post('/category/delete', [CategoryController::class, 'destroy'])->middleware('auth')->name('category.delete');
Route::post('/category/update', [CategoryController::class, 'update'])->middleware('auth')->name('category.create');
Route::post('/category/sort', CategorySortController::class)->middleware('auth')->name('category.sort');



Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

require __DIR__.'/auth.php';
