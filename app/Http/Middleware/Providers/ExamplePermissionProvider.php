<?php
namespace App\Http\Middleware\Providers;
use App\Http\Middleware\Providers\PermissionProviderInterface;

class ExamplePermissionProvider implements PermissionProviderInterface
{
	public function getAccessList() 
	{
		return true;
	}
	public function isPermitted($userPermissions, $request, $next) 
	{
		$permissions = $this->getPermissionsFromDatabase();
		$requiredPermission = $permissions[$request->path()];
		if (in_array($requiredPermission, $userPermissions->pluck("name")->toArray())) {
			return $next($request);
		}
		return "no permission";
	}
	public function requiresPermissions($uri) 
	{
		return true;
	}

	public function getPermissionsFromDatabase() {
		return array(
			"api/v1/users/add" => "CREATE_USER",
			"api/v1/permissions/add" => "CREATE_PERMISSION",
			"api/v1/users/{{id}}/delete" => "DELETE_USER",
		);
	}
}