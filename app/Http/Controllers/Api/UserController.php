<?php

namespace App\Http\Controllers\API;

use App\Models\User;
use App\Traits\ApiResponse;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Resources\UserResource;
use App\Http\Requests\Api\UserRequest;

class UserController extends Controller
{

    use ApiResponse;
    /**
     * Display a listing of the resource.
     */

    public function index(Request $request)
    {
        $data = User::query();

        if ($request->has('search') && $request->search != '') {
            $data->where('name', 'like', '%' . $request->search . '%');
        }

        $users = $data->paginate(PAGINATION_COUNT);

        return $this->successResponse(UserResource::collection($users));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(UserRequest $request)
    {

        try {

            $userData = $request->only(['name', 'email', 'phone', 'role']);
            $userData['password'] = bcrypt($request->password);


            if ($request->hasFile('photo')) {
                $userData['photo'] = saveImage('images', $request->file('photo'));
            }


            $user = User::create($userData);
            return $this->successResponse(UserResource::make($user), 'User Created Successfully', 201);
        } catch (\Exception $e) {
            return $this->errorResponse('Something Wrong Try Again', 500);
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        try {
            $user = User::findOrFail($id);
            return $this->successResponse(UserResource::make($user));
        } catch (\Illuminate\Database\Eloquent\ModelNotFoundException $e) {

            return $this->errorResponse('User Not Found', 404);
        } catch (\Exception $e) {

            return $this->errorResponse('Something Wrong Try Again', 500);
        }
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UserRequest $request, string $id)
    {
        try {
            $user = User::findOrFail($id);
            $userData = $request->only(['name', 'email', 'phone', 'role']);
            if ($request->filled('password')) {
                $userData['password'] = bcrypt($request->password);
            }
            if ($request->hasFile('photo')) {
                $userData['photo'] = saveImage('images', $request->file('photo'));
            }

            $user->update($userData);

            return $this->successResponse(UserResource::make($user->fresh()), 'User Updated Successfully', 200);
        } catch (\Illuminate\Database\Eloquent\ModelNotFoundException $e) {

            return $this->errorResponse('User Not Found', 404);
        } catch (\Exception $e) {
            return $this->errorResponse('Something Wrong Try Again', 500);
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        try {
            $user = User::findOrFail($id);
            $user->delete();
            return $this->successResponse(null, 'Deleted Successfully');
        } catch (\Illuminate\Database\Eloquent\ModelNotFoundException $e) {

            return $this->errorResponse('User Not Found', 404);
        } catch (\Exception $e) {

            return $this->errorResponse('Something Wrong Try Again', 500);
        }
    }
}
