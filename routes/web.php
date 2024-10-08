<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Artisan;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\Admin\RoleController;
use App\Http\Controllers\Admin\UserController;
use App\Http\Controllers\Admin\AdminController;
use App\Http\Controllers\Admin\DeliveryController;
use App\Http\Controllers\Admin\OrderController;
use App\Http\Controllers\Admin\OrderOutController;
use App\Http\Controllers\Admin\PartyController;
use App\Http\Controllers\Admin\PermissionController;
use App\Http\Controllers\Admin\ThreadController;
use App\Http\Controllers\Admin\QualityController;

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
        Route::resource('quality', QualityController::class);
        Route::resource('thread', ThreadController::class);
        Route::resource('party', PartyController::class);
        Route::resource('order', OrderController::class);
        Route::resource('order_out', OrderOutController::class);
        Route::resource('delivery', DeliveryController::class);

        Route::resource('users', UserController::class);
        Route::get('get-party-data/{id}', [PartyController::class, 'getPartyData'])->name('getPartyData');
        Route::get('order-detail/{id}', [OrderOutController::class, 'orderDetail'])->name('orderDetail');
        Route::get('users-all', [UserController::class, 'getAllUser'])->name('getAllUser');

        Route::get('party-all', [PartyController::class, 'getAllParties'])->name('getAllParties');
        Route::get('party-orders/{id}', [PartyController::class, 'getPartyOrders'])->name('getPartyOrders');
        Route::get('party-threads/{id}', [PartyController::class, 'getPartyThreads'])->name('getPartyThreads');



        // Orders Routes
        Route::get('order-all', [OrderController::class, 'getAllOrder'])->name('getAllOrder');
        Route::get('order-out-all', [OrderOutController::class, 'getAllOrderOut'])->name('getAllOrderOut');
        Route::get('order-out-view/{id}', [OrderOutController::class, 'viewOrderOut'])->name('orderOut.view');
        Route::get('order-out-print/{id}', [OrderOutController::class, 'printOrderOut'])->name('orderOut.print');
        Route::get('order-view/{id}', [OrderController::class, 'viewOrder'])->name('order.view');
        // Route::get('get-party-data/{id}', [OrderController::class, 'getPartyData'])->name('getPartyData');
        Route::get('thread-all', [ThreadController::class, 'getAllThreads'])->name('getAllThreads');
        Route::get('thread-by-id/{id}', [ThreadController::class, 'getThreadById'])->name('getThreadById');

        //quality routes
        Route::get('quality-all', [QualityController::class, 'getAllqualities'])->name('getAllqualities');
        Route::get('quality-by-id/{id}', [QualityController::class, 'getQualityById'])->name('getQualityById');

    });
});
