<?php

use App\Http\Controllers\Api\AuthController;
use App\Http\Controllers\CategoryController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

Route::get('/user', function (Request $request) {
    return $request->user();
})->middleware('auth:sanctum');
Route::group([], function () {
    Route::post("login", [AuthController::class, 'login']);
    Route::post("register", [AuthController::class, 'register']);


    Route::group(['middleware'=>'verify.token'],function(){
        Route::post('logout',[AuthController::class,'logout']);
        Route::post('refresh',[AuthController::class,'refresh']);

    });

});
Route::group(['middleware'=>'verify.token','Lang','checkpass'],function(){
Route::post('create',[CategoryController::class,'create']);
Route::post('update',[CategoryController::class,'update']);
Route::post('delete',[CategoryController::class,'delete']);
Route::post('getAll',[CategoryController::class,'getAll'])->middleware('Lang','checkpass');
Route::post('getCategById',[CategoryController::class,'getCategById']);
});