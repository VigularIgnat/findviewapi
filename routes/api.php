<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\Data\IndexDataController;
use App\Http\Controllers\Api\AuthController;
use App\Http\Controllers\Api\HashController;
use App\Http\Controllers\Api\TypeController;
/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "api" middleware group. Make something great!
|
*/

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});

Route::prefix('v1')->group(function () {
    Route::get('city/hash/{hash}/{letter}',[IndexDataController::class,'index'])->where(['hash' => '[A-Za-z0-9]+','letter' => '[A-Za-z]+']);
    Route::middleware('auth:sanctum')->group(function () {
        Route::get('/type', [TypeController::class,'index']);
        Route::post('/type', [TypeController::class,'store']);
        Route::put('/type',[TypeController::class,'update']);
        Route::delete('/types/{id}',[TypeController::class,'destroy'] );
    });
});

//http://127.0.0.1:8000/api/city/hash{}/{}
//Route::middleware('auth:sanctum')->post('gethash', [HashController::class, 'gethash']);

Route::controller(AuthController::class)->group(function () {
    Route::post('register', 'register');
    Route::post('login', 'login');
    Route::post('logout', 'logout');
    Route::post('refresh','refresh');
});