<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\API\UserController;

Route::get('/user', function (Request $request) {
    return $request->user();
})->middleware('auth:sanctum');



// *****************Begin User Routes*****************//
  Route::group(['prefix'=>'users'],function(){
    Route::get('/',[UserController::class,'index']);
    Route::post('store',[UserController::class,'store']);
    Route::post('show/{id}',[UserController::class,'show']);
    Route::post('update/{id}',[UserController::class,'update']);
    Route::post('delete/{id}',[UserController::class,'destroy']);


  });

// *****************End User Routes******************//
