<?php

namespace App\Http\Middleware;
use Tymon\JWTAuth\Facades\JWTAuth;
use Tymon\JWTAuth\Exceptions\JWTException;
use Tymon\JWTAuth\Exceptions\TokenExpiredException;
use Tymon\JWTAuth\Exceptions\TokenInvalidException;
use App\User;
use App\Http\Middleware\Providers\AllGoodPermissionProvider;
use App\Http\Middleware\Providers\PermissionProviderInterface;

use Closure;

class PermissionsMiddleware
{

    public function handle($request, Closure $next)
    {
        $uri = $request->path();
        $method = $request->method();
        $token = JWTAuth::parseToken();
        $user = $token->authenticate();
        $userPermissions = true;

        $permissionProvider = new AllGoodPermissionProvider();

        switch ($method) {
            case PermissionProviderInterface::GET: 
                if (! $permissionProvider->isPermitted($uri, $userPermissions)) {
                    return $this->accessNotAllowedDefaultResponse();
                }
                return $this->permissionsHandlerGET($uri, $user, $request, $next);
            break;
            case PermissionProviderInterface::POST: 
                if (! $permissionProvider->isPermitted($uri, $userPermissions)) {
                    return $this->accessNotAllowedDefaultResponse();
                }
                return $this->permissionsHandlerPOST($uri, $user, $request, $next);
            break;
            case PermissionProviderInterface::PATCH: 
                if (! $permissionProvider->isPermitted($uri, $userPermissions)) {
                    return $this->accessNotAllowedDefaultResponse();
                }
                return $this->permissionsHandlerPATCH($uri, $user, $request, $next);
            break;
            case PermissionProviderInterface::DELETE: 
                if (! $permissionProvider->isPermitted($uri, $userPermissions)) {
                    return $this->accessNotAllowedDefaultResponse();
                }
                return $this->permissionsHandlerDELETE($uri, $user, $request, $next);
            break;

        }
        return $next($request);
    }

    public function accessNotAllowedDefaultResponse() {
        return response()->json([
            'message' => 'action_not_allowed',
            'reason' => 'You have no right to execute this endpoint.'
        ]);
    }

    public function permissionsHandlerGET($uri, $user, $request, $next) {
        // custom GET handlers
    }

    public function permissionsHandlerPOST($uri, $user, $request, $next) {
        // custom POST handlers
    }

    public function permissionsHandlerPATCH($uri, $user, $request, $next) {

        $onlyUserUpdate = env('API_USER_ONLY_PROFILE_UPDATE');

        if ((($uri == 'api/v1/users/' . $user['id'] . '/edit') == false) && ($onlyUserUpdate == true)) {
                return response()->json([
                    'message' => 'action_not_allowed',
                    'reason' => 'You have no rights for edit!'
                ]);
         }

         return $next($request);
    }

    public function permissionsHandlerDELETE($uri, $user, $request, $next) {
        // custom POST handlers
    }

}