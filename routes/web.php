<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Artisan;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\Admin\RoleController;
use App\Http\Controllers\Admin\UserController;
use App\Http\Controllers\Admin\AdminController;
use App\Http\Controllers\Admin\DeliveryController;
use App\Http\Controllers\Admin\OrderController;
use App\Http\Controllers\Admin\PartyController;
use App\Http\Controllers\Admin\PermissionController;
use App\Http\Controllers\Admin\ThreadController;

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
    return redirect()->route('login');
});

Route::get('/login', function () {
    return view('auth.login');
})->name('login');

Route::get('/cache-clear', function () {
    Artisan::call('optimize:clear');
    return true;
});


Auth::routes();

// Route::get('/home', [HomeController::class, 'index'])->name('home');


Route::group(['prefix' => 'admin'], function () {

    //Admin Routes
    Route::get('dashboard', [AdminController::class, 'AdminDashboard'])->name('home');
    Route::group(['as' => 'admin.'], function () {
        //Roles
        Route::resource('role', RoleController::class);
        Route::resource('permissions', PermissionController::class);
        Route::resource('thread', ThreadController::class);
        Route::resource('party', PartyController::class);
        Route::resource('order', OrderController::class);
        Route::resource('delivery', DeliveryController::class);

        Route::resource('users', UserController::class);
        Route::get('users-all', [UserController::class, 'getAllUser'])->name('getAllUser');
        Route::get('party-all', [PartyController::class, 'getAllParties'])->name('getAllParties');
    });
});
