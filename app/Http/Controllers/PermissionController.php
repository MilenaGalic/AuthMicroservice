<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Http\JsonResponse;
use Illuminate\Validation\ValidationException;
use Illuminate\Http\Exception\HttpResponseException;
use Illuminate\Support\Facades\Input;
use Illuminate\Support\Facades\Hash;
use App\Permission;
use Illuminate\Database\QueryException;

class PermissionController extends Controller
{

    public function getPermissions(Request $request)
    {
        $permissions = Permission::get();

        return response()->json([
            'message' => 'permissions_index',
            'data' => response()->json($permissions)
        ]);
    }

    public function createPermission(Request $request) 
    {

        $this->validate($request, [
            'name' => 'max:255|unique:permissions,name|required',
            'description' => 'max:255'
        ]);


        $permission = new Permission ($request->all());

        $permission->save();

        return response()->json([
             'message' => 'permission_created',
             'data' => response()->json($permission)
        ]);
    }


}