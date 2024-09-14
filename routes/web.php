<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\Dashboard\BlogsController;
use App\Http\Controllers\Dashboard\DashboardController;
use App\Http\Controllers\Dashboard\PermissionsController;
use App\Http\Controllers\Dashboard\RolesController;
use App\Http\Controllers\Dashboard\UsersController;

Route::get('/', function () {
    return view('welcome');
});

Auth::routes();

Route::get('/home', [HomeController::class, 'index'])->name('frontend.index');

Route::get('/users', [UsersController::class, 'index'])->name('backend.users.index');


Route::middleware(['auth', 'role:user|backend'])
    ->name('backend.')
    ->prefix('/admin')
    ->group(function () {
        Route::get('', [DashboardController::class, 'index'])->name('index');
        Route::resource('/users', UsersController::class);
        Route::resource('/roles', RolesController::class);
        Route::resource('/permissions', PermissionsController::class);
        Route::resource('/blogs', BlogsController::class);
    });
