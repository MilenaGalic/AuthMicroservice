<?php

namespace App;
 
use Illuminate\Database\Eloquent\Model;
use DB;
 
class Permission extends Model
 
{
 
   protected $fillable = ['name','description'];

   public function getUserIdsByPermission($permission_id)
   {
   		$users_ids = DB::table('permission_user')
   			->select('user_id')
   			->where('permission_id', '=', $permission_id)
   			->get();
   			
   		return $users_ids;
   }

}