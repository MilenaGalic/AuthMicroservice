<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Http\JsonResponse;
use Illuminate\Validation\ValidationException;
use Illuminate\Http\Exception\HttpResponseException;
use Illuminate\Support\Facades\Input;
use Illuminate\Support\Facades\Hash;
use App\User;
use Illuminate\Database\QueryException;

class UserController extends Controller
{

    public function createUser(Request $request) 
    {
        // var_dump($request->request->get('password'));

        $this->validate($request, [
            'name' => 'max:255',
            'email' => 'required|unique:users,email|email|max:255',
            'password' => 'required'
        ]);

        $user = new User ($request->except('password'));
        $user->password = Hash::make($request->request->get('password'));

        $user->save();

        return response()->json([
             'message' => 'user_created',
             'data' => response()->json($user)
        ]);
    }

    public function deleteUser(Request $request, $id)
    {
        if (! $user = User::find($id)) 
        {
            return response()->json([
            'message' => 'non_existing_user',
        ]);
        }

        try 
        {
           $user->delete();
        }
        catch (QueryException $e) {
             return response()->json(['database_exception'], $e->getStatusCode());
        }

        $data = array(
            "user_id" => $id,
            "token" => "User's token has been automatically revoked."
        );

        return response()->json([
            'message' => 'user_deleted',
            'data' => response()->json($data)
        ]);
    }

    public function getUser(Request $request, $id)
    {
        $user = User::find($id);
        /* 
            Once we introduce Permissions (or Roles/Permissions)
            this part will be updated, in order to include
            information about permissions/roles to a getUser info.
         */
        return response()->json([
            'message' => 'user_viewed',
            'data' => response()->json($user)
        ]);
    }

    public function getUsers(Request $request)
    {
        $users = User::get();

        return response()->json([
            'message' => 'users_index',
            'data' => response()->json($users)
        ]);
    }
}