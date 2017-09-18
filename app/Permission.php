<?php

namespace App;
 
use Illuminate\Database\Eloquent\Model;
use DB;
 
class Permission extends Model
 
{
 
   protected $fillable = ['name','description'];

   public function getUserIdsByPermission($permissionid)
   {
   		$users = DB::table('permission_user')
   			->select('user_id')
   			->where('permission_id', '=', $permissionid)
   			->get();
   			
   		return $users;
   }

   public function getPermissionsForUser($userid) 
   {
      $permissions = DB::table('permission_user')
            ->select('permission_id','name')
            ->where('user_id', '=', $userid)
            ->join('permissions', 'permissions.id', '=', 'permission_user.permission_id')
            ->get();

      return $permissions;
   }

}