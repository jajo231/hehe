<?php

use App\Http\Controllers\AttributeController;
use App\Http\Controllers\DateController;
use App\Http\Controllers\GameController;
use App\Http\Controllers\ProfileController;
use Illuminate\Foundation\Application;
use Illuminate\Support\Facades\Auth;
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

Route::post('/logout', function () {
    Auth::logout();
    return redirect('/');
})->name('logout');

Route::get('/dashboard', function () {
    return Inertia::render('Dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');

    Route::get('/games', [GameController::class, 'index'])->name('games.index');
    Route::post('/games', [GameController::class, 'store'])->name('games.store')->middleware('role:admin');
    Route::get('/creategames', [GameController::class, 'create'])->name('games.create')->middleware('role:admin');
    Route::get('/games/edit/{game}', [GameController::class, 'edit'])->name('games.edit')->middleware('role:admin');
    Route::post('/games/{game}', [GameController::class, 'update'])->name('games.update')->middleware('role:admin');
    Route::delete('/games/{game}', [GameController::class, 'destroy'])->name('games.destroy')->middleware('role:admin');

    Route::get('/attributes', [AttributeController::class, 'index'])->name('attributes.index');
    Route::get('/date', [DateController::class, 'dateIndex'])->name('dateIndex');
    Route::get('/attributes/{attribute}', [AttributeController::class, 'show'])->name('attributes.show');
});

require __DIR__.'/auth.php';
