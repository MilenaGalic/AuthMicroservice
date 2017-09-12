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
        $user = User::find($id);
        $user->delete();

        $data = array(
            "user_id" => $id,
            "token" => "User's token has been automatically revoked."
        );

        return response()->json([
            'message' => 'user_deleted',
            'data' => response()->json($data)
        ]);
    }
}