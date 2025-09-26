<?php

namespace App\Http\Controllers\Api;

use App\Models\Permission;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Resources\PermissionResource;
use App\Traits\ApiResponse;

class PermissionsController extends Controller
{
    use ApiResponse;
    public function getPermissions(){
        $permissions=Permission::with('groups')->paginate(PAGINATION_COUNT);
        return $this->successResponse(PermissionResource::collection($permissions));
    }
}
