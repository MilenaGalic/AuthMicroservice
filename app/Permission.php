<?php

namespace App;
 
use Illuminate\Database\Eloquent\Model;
use DB;
 
class Permission extends Model
 
{
 
   protected $fillable = ['name','description'];

   public function getUserIdsByPermission($pid)
   {
   		$users = DB::table('permission_user')
   			->select('user_id')
   			->where('permission_id', '=', $pid)
   			->get();
   			
   		return $users;
   }

   public function getPermissionsForUser($uid) 
   {
      $permissions = DB::table('permission_user')
            ->select('permission_id','name')
            ->where('user_id', '=', $uid)
            ->join('permissions', 'permissions.id', '=', 'permission_user.permission_id')
            ->get();

      return $permissions;
   }

   public function existsForUser($uid, $pid)
   {
      $user = User::find($uid);
      $permissions = (new Permission())->getPermissionsForUser($user['id']);

      foreach ($permissions as $permission) {
            if (($permission->permission_id) == $pid)
                return true;
        }
      return false;
   }

   public function assignToUser($uid, $pid)
   {
      try {
         $permission = Permission::find($pid);
         User::find($uid)->permissions()->attach($permission);
      } catch (Illuminate\Database\QueryException $e) {
         return false;
      }
      return true;
   }

   // Antonym to 'Assign' ? :) dissociate, deallocate?
   public function dissociateFromUser($uid, $pid)
   {
      try {
         $permission = Permission::find($pid);
         User::find($uid)->permissions()->detach($permission);
      } catch (Illuminate\Database\QueryException $e) {
         return false;
      }
      return true;
   }

}