<?php

namespace App\Http\Controllers\Api;
use App\Models\User;
use App\Traits\ApiResponse;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Resources\UserResource;
use Illuminate\Support\Facades\Auth;



class AuthController extends Controller
{
   use ApiResponse;

  public function login(Request $request){
try{
       if( Auth::attempt(['email'=>$request->email , 'password'=>$request->password]))
       {
        $user=Auth::user();
        $token =$user->createToken('userToken')->plainTextToken;
  
        return $this->successResponse([UserResource::make($user),'Token'=>$token]);
          }else{
             return $this->errorResponse('   Email Or Password INcorrect Please Try Again', 500);
          }
       }catch(\Exception $e){
   
     return $this->errorResponse('Something Wrong Try Again', 500);

    }
  }

    
}
