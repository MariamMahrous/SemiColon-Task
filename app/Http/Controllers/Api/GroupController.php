<?php

namespace App\Http\Controllers\Api;

use App\Models\Group;
use App\Traits\ApiResponse;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Resources\GroupResource;
use App\Http\Requests\Api\GroupRequest;

class GroupController extends Controller
{
    use ApiResponse;
    /**
     * Display a listing of the resource.
     */

    public function index(Request $request)
    {
        $groups = Group::with('users')->paginate(PAGINATION_COUNT);

        return $this->successResponse(GroupResource::collection($groups));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(GroupRequest $request)
    {
        try {
            $group = Group::create($request->only(['name', 'description']));
            if ($request->has('users')) {
                $group->users()->attach((array) $request->users);
            }
            $group = $group->fresh('users');
            return $this->successResponse(GroupResource::make($group), 'Group Created Successfully', 201);
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
            $Group = Group::with('users')->findOrFail($id);
            return $this->successResponse(GroupResource::make($Group));
        } catch (\Illuminate\Database\Eloquent\ModelNotFoundException $e) {

            return $this->errorResponse('Group Not Found', 404);
        } catch (\Exception $e) {

            return $this->errorResponse('Something Wrong Try Again', 500);
        }
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(GroupRequest $request, string $id)
    {
        try {
            $group = Group::findOrFail($id);
            $group->update($request->only(['name', 'description']));
            if ($request->has('users')) {
                $group->users()->sync((array) $request->users);
            }
            $group->load('users');

            return $this->successResponse(GroupResource::make($group), 'Group Updated Successfully', 200);
        } catch (\Illuminate\Database\Eloquent\ModelNotFoundException $e) {

            return $this->errorResponse('Group Not Found', 404);
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
            $group = Group::findOrFail($id);
            $group->delete();
            return $this->successResponse(null, 'Deleted Successfully');
        } catch (\Illuminate\Database\Eloquent\ModelNotFoundException $e) {

            return $this->errorResponse('Group Not Found', 404);
        } catch (\Exception $e) {

            return $this->errorResponse('Something Wrong Try Again', 500);
        }
    }


    public function assignPermissions(Request $request, $id)
    {

        $request->validate([
            'permissions' => 'required|array',
            'permissions.*' => 'exists:permissions,id',
        ]);


        $group = Group::findOrFail($id);


        $group->permissions()->sync($request->permissions);
        $group->load('permissions', 'users');
        return $this->successResponse(GroupResource::make($group), 'Permissions assigned to group successfully', 200);
    }
}
