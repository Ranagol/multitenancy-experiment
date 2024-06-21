<?php

use App\Models\User;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});

Route::get(
    '/andor',
    function () {
        return User::first()?->toArray();
    }
);
