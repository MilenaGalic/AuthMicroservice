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


}