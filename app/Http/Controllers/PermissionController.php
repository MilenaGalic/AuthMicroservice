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
use App\User;
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

    public function deletePermission(Request $request, $id)
    {
        if (! $permission = Permission::find($id)) 
        {
            return response()->json([
                'message' => 'non_existing_permission',
            ]);
        }

        // first get affected users
        $users_ids = $permission->getUserIdsByPermission($id);

        // then delete with InnoDB cascade
        $permission->delete();

        return response()->json([
            'message' => 'permission_deleted',
            'UserIds_affected' => $users_ids
        ]);
    }

    public function getPermissionsByUid(Request $request, $uid)
    {
        $user = User::find($uid);

        $permissions = (new Permission())->getPermissionsForUser($user['id']);

        if (! $permissions->isEmpty()) {
            return response()->json([
                'message' => 'user_has_permissions',
                'data' => $permissions
            ]);
        }
        
        return response()->json([
                'message' => 'user_has_no_permissions'
        ]);

    }

}