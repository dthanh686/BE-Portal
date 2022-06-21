<?php

use App\Http\Controllers\AdminController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\ChecklogController;
use App\Http\Controllers\MemberRoleController;
use App\Http\Controllers\RegisterForgetController;
use App\Http\Controllers\RegisterLeaveController;
use App\Http\Controllers\RegisterOTController;
use App\Http\Controllers\RequestController;
use App\Http\Controllers\WorksheetController;
use App\Http\Controllers\MemberController;
use App\Http\Controllers\NotificationController;
use App\Http\Controllers\RegisterLateEarlyController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/
//
//Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
//    return $request->user();
//});

Route::controller(AuthController::class)->group(function () {
    Route::post('/login', 'login')->name('login');
    Route::delete('/logout', 'logout');
    Route::post('/refresh-token', 'refresh');
    Route::patch('/change-password', 'changePassword');
});
Route::prefix('worksheet')
    ->controller(WorksheetController::class)
    ->group(function () {
        Route::get('', 'index');
        Route::get('/show-id', 'getById');
        Route::get('/show-date', 'getByDate');
    });

Route::prefix('register-leave')
    ->controller(RegisterLeaveController::class)
    ->group(function () {
        Route::post('/store', 'store');
        Route::get('/show', 'show');
        Route::put('/update/{id}', 'update');
        Route::delete('/delete/{id}', 'destroy');
    });
Route::get('/time-log', [ChecklogController::class, 'index']);
Route::prefix('register-forget')
    ->controller(RegisterForgetController::class)
    ->group(function () {
        Route::post('/store', 'store');
        Route::get('/show', 'show');
        Route::put('/update/{id}', 'update');
        Route::delete('/delete/{id}', 'destroy');
    });
Route::prefix('members')
    ->controller(MemberController::class)
    ->group(function () {
        Route::get('/edit', 'edit');
        Route::put('/update', 'update');
    });

Route::apiResource('notification', NotificationController::class)->only('index', 'show');
Route::prefix('register-late-early')
    ->controller(RegisterLateEarlyController::class)
    ->group(function () {
        Route::post('/store', 'store');
        Route::get('/show', 'show');
        Route::put('/update/{id}', 'update');
        Route::delete('/delete/{id}', 'destroy');
    });
Route::prefix('register-ot')
    ->controller(RegisterOTController::class)
    ->group(function () {
        Route::post('/store', 'store');
        Route::get('/show', 'show');
        Route::put('/update/{id}', 'update');
        Route::delete('/delete/{id}', 'destroy');
    }); 
Route::prefix('request')
    ->controller(RequestController::class)
    ->group(function () {
        Route::get('/sent', 'index');
        Route::get('/show', 'show');
        Route::put('/confirm/{id}', 'update');
        Route::get('/delete', 'destroy');
    });
Route::prefix('admin')
    ->controller(AdminController::class)
    ->group(function () {
        Route::prefix('request')->group(function () {
            Route::get('/get', 'index');
            Route::put('/approve/{id}', 'update');
        });
        Route::prefix('notifications')->group(function () {
            Route::post('/store', 'createNotifications');
            Route::get('/list','listNotifications');
            Route::put('/update/{id}','updateStatusNotice');
        });
    });
