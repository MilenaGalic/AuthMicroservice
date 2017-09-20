<?php

namespace App\Http\Middleware\Providers;

/*
 * getAccessList() - provides Array of uris and required permissions
 * isPermitted($uri, $permissions) - checks if specific uri and permission(s) combination is acceptable, returns TRUE/FALSE
 * requiresPermissions($uri) - returns a permission or array of permissions which is required for specific uri/endpoint
 */ 
interface PermissionProviderInterface 
{
	const CONNECT = 'CONNECT';
    const DELETE  = 'DELETE';
    const GET     = 'GET';
    const HEAD    = 'HEAD';
    const OPTIONS = 'OPTIONS';
    const POST    = 'POST';
    const PUT     = 'PUT';
    const PATCH   = 'PATCH';

	public function getAccessList();
	public function isPermitted($userPermissions, $request, $next);
	public function requiresPermissions($uri);
}