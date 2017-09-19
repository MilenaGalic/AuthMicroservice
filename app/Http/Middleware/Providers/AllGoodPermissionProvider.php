<?php
namespace App\Http\Middleware\Providers;
use App\Http\Middleware\Providers\PermissionProviderInterface;

class AllGoodPermissionProvider implements PermissionProviderInterface
{
	public function getAccessList() 
	{
		return true;
	}
	public function isPermitted($uri, $permissions) 
	{
		return true;
	}
	public function requiresPermissions($uri) 
	{
		return true;
	}
}