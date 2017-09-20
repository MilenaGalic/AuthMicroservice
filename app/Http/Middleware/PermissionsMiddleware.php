<?php

namespace App\Http\Middleware;
use Tymon\JWTAuth\Facades\JWTAuth;
use Tymon\JWTAuth\Exceptions\JWTException;
use Tymon\JWTAuth\Exceptions\TokenExpiredException;
use Tymon\JWTAuth\Exceptions\TokenInvalidException;
use App\User;
use App\Permission;
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

        $permission = new Permission();
        $userPermissions = $permission->getPermissionsForUser($user->id);

        $permissionProvider = new AllGoodPermissionProvider();

        if (env('API_USE_PERMISSION_PROVIDER'))
        {
            return $permissionProvider->isPermitted($userPermissions, $request, $next);
        }

        switch ($method) {
            case PermissionProviderInterface::GET: 
                return $this->permissionsHandlerGET($uri, $user, $request, $next);
            break;
            case PermissionProviderInterface::POST: 
                return $this->permissionsHandlerPOST($uri, $user, $request, $next);
            break;
            case PermissionProviderInterface::PATCH: 
                return $this->permissionsHandlerPATCH($uri, $user, $request, $next);
            break;
            case PermissionProviderInterface::DELETE: 
                return $this->permissionsHandlerDELETE($uri, $user, $request, $next);
            break;
            default:
                return $this->accessNotAllowedDefaultResponse();
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
        return $next($request);
    }

    public function permissionsHandlerPOST($uri, $user, $request, $next) {
        return $next($request);
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
        return $next($request);
    }

}