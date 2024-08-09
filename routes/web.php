<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Admin\AdminUserController;
use App\Http\Controllers\Admin\DashboardController;
use App\Http\Controllers\Admin\AdminLoginController;

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

$prefix = 'admin';

// Route::prefix($prefix)->group(function () {

Route::prefix($prefix)->group(function () {
    Route::get('/', [AdminLoginController::class, 'login'])->name('login_page');
    Route::post('/login', [AdminLoginController::class, 'dologin'])->name('do_login');

    Route::middleware(['prevent-back-history'])->group(function () {
        Route::controller(AdminLoginController::class)->group(function () {
            Route::get('/profile', 'EditProfile')->name('profile_page');
            Route::post('/updateprofileimage', 'UpdateProfileImage')->name('updateprofileimage');
            Route::post('/checkoldpassword', 'CheckOldPassword')->name('checkoldpassword');
            Route::post('/changepassword', 'ChangePassword')->name('changepassword');
            Route::get('/logout', 'Logout')->name('logout');
        });

        //Dashbaord
        Route::controller(DashboardController::class)->group(function () {
            Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');
        });

        //User Page
        Route::resource('user', AdminUserController::class);
        Route::post('/user/user_list', [AdminUserController::class, 'user_list'])->name('user_list');
    });
});
