<?php

use App\Http\Controllers\ProfileController;
use App\Models\User;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});

// Route with the role middleware, temporarily commented out
//Route::get(
//    '/andor',
//    function () {
//        return User::first()?->toArray();
//    }
//)->middleware('role:admin');

//Without the role middleware
Route::get(
    '/andor',
    function () {
//        return User::first()?->toArray();
        xdebug_info();
        exit;
    }
);

Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

require __DIR__.'/auth.php';
