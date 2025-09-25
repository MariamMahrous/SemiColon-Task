<?php

namespace App\Http\Controllers\API;

use App\Models\User;
use App\Http\Controllers\Controller;
use App\Http\Resources\UserResource;
use App\Http\Requests\Api\UserRequest;
use App\Traits\ApiResponse;

class UserController extends Controller
{

    use ApiResponse;
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
         
     $users=User::paginate(PAGINATION_COUNT);
     return $this->successResponse(UserResource::collection($users));
 
       
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(UserRequest $request)
    {
         
        try{
           
            $userData=$request->only(['name','email','phone','role']);
            $userData['password']=bcrypt($request->password);

          
            if($request->hasFile('photo')){
               $userData['photo'] = saveImage('images',$request->file('photo'));
            }
          

            $user =User::create($userData);
            return $this->successResponse(UserResource::make($user),'User Created Successfully',201);
         

        }catch(\Exception $e){
            return $this->errorResponse('Something Wrong Try Again',500);
            
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
         try{

        }catch(\Exception $e){
            
        }
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
         try{

        }catch(\Exception $e){
            
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
         try{

        }catch(\Exception $e){
            
        }
    }
}
