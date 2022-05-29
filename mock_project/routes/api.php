<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\ChecklogController;
use App\Http\Controllers\MemberRoleController;
use App\Http\Controllers\WorksheetController;
use Illuminate\Http\Request;
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

Route::middleware('method')->group(function () {
    Route::post('/login', [AuthController::class, 'login'])->name('login');
    Route::delete('/logout', [AuthController::class, 'logout']);
    Route::patch('/change-password/{id}', [AuthController::class, 'changePassWord']);
});
Route::apiResource('worksheet', WorksheetController::class);
Route::apiResource('member-role', MemberRoleController::class)->only('show');
Route::apiResource('time-log', ChecklogController::class);
