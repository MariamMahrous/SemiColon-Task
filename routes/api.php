<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\AuthController;
use App\Http\Controllers\API\UserController;
use App\Http\Controllers\Api\GroupController;
use App\Http\Controllers\Api\PermissionsController;

Route::get('/user', function (Request $request) {
    return $request->user();
})->middleware('auth:sanctum');




 Route::post('login',[AuthController::class,'login']);
// *****************Begin User Routes*****************//
Route::group(['middleware'=>['auth:sanctum']],function(){


  Route::group(['prefix'=>'users'],function(){
    Route::get('/',[UserController::class,'index'])->middleware('permission:view_users');
    Route::post('store',[UserController::class,'store'])->middleware('permission:create_users');
    Route::post('show/{id}',[UserController::class,'show'])->middleware('permission:show-users');
    Route::post('update/{id}',[UserController::class,'update'])->middleware('permission:update_users');
    Route::post('delete/{id}',[UserController::class,'destroy'])->middleware('permission:delete_users');


     });
  });
 // *****************End User Routes******************//

 // *****************Begin Groups Routes*****************//
 Route::group(['middleware'=>['auth:sanctum', 'checkRole']],function(){
 Route::group(['prefix'=>'groups'],function(){
    Route::get('/',[GroupController::class,'index']);
    Route::post('store',[GroupController::class,'store']);
    Route::post('show/{id}',[GroupController::class,'show']);
    Route::post('update/{id}',[GroupController::class,'update']);
    Route::post('delete/{id}',[GroupController::class,'destroy']);
    Route::post('/{id}/permissions', [GroupController::class, 'assignPermissions'])->middleware('permission:assign-roles');

  });

  
 Route::get('permissions',[PermissionsController::class,'getPermissions']);


  });
// *****************End Groups Routes******************//
