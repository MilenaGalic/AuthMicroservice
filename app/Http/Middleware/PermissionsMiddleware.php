<?php

namespace App\Http\Middleware;
use Tymon\JWTAuth\Facades\JWTAuth;
use Tymon\JWTAuth\Exceptions\JWTException;
use Tymon\JWTAuth\Exceptions\TokenExpiredException;
use Tymon\JWTAuth\Exceptions\TokenInvalidException;
use App\User;

use Closure;

class PermissionsMiddleware
{

    public function handle($request, Closure $next)
    {
        $onlyUserUpdate = env('API_USER_ONLY_PROFILE_UPDATE');
        $uri = $request->path();
        $method = $request->method();
        $token = JWTAuth::parseToken();
        $user = $token->authenticate();

        // This is just a dirty example for now...
        // Later I will have to refactor this completely
        // echo $uri . " | " . $method;

        switch ($method) {
            // case "GET": 
            //     $this->permissionsHandlerGET($request); 
            // break;
            // case "POST" : 
            //     $this->permissionsHandlerPOST($request); 
            // break;
            case "PATCH" : 
                if (($uri == 'api/v1/users/' . $user['id'] . '/edit') == false) {
                        return response()->json([
                             'message' => 'action_not_allowed',
                             'reason' => 'You have no rights for edit!'
                        ]);
                }
            break;
            // case "DELETE" :
            //     $this->permissionsHandlerDELETE($request); 
            // break;
        }

        return $next($request);
    }

}