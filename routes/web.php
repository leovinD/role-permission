<?php

use App\Http\Controllers\UserController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});

Route::get('/users/permissions/{role}', [UserController::class, 'getPermissionsForRole']);
Route::resource('users', UserController::class);
