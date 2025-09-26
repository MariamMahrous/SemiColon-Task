<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\AuthController;
use App\Http\Controllers\API\UserController;
use App\Http\Controllers\Api\GroupController;

Route::get('/user', function (Request $request) {
    return $request->user();
})->middleware('auth:sanctum');




 Route::post('login',[AuthController::class,'login']);
// *****************Begin User Routes*****************//
Route::group(['middleware'=>['auth:sanctum', 'checkRole']],function(){


  Route::group(['prefix'=>'users'],function(){
    Route::get('/',[UserController::class,'index']);
    Route::post('store',[UserController::class,'store']);
    Route::post('show/{id}',[UserController::class,'show']);
    Route::post('update/{id}',[UserController::class,'update']);
    Route::post('delete/{id}',[UserController::class,'destroy']);


  });

// *****************End User Routes******************//

// *****************Begin Groups Routes*****************//
Route::group(['prefix'=>'groups','middleware'=>'checkRole'],function(){
    Route::get('/',[GroupController::class,'index']);
    Route::post('store',[GroupController::class,'store']);
    Route::post('show/{id}',[GroupController::class,'show']);
    Route::post('update/{id}',[GroupController::class,'update']);
    Route::post('delete/{id}',[GroupController::class,'destroy']);


  });

// *****************End Groups Routes******************//
});