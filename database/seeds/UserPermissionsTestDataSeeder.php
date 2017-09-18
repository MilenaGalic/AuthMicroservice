<?php

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Seeder;

use App\User;
use App\Permission;

class UserPermissionTestDataSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $permissions = App\Permission::all();
        $user = User::find(2);
        $user->permissions()->attach($permissions->random(rand(1, 3))->pluck('id')->toArray()); 

        $permissions = App\Permission::all();
        $user = User::find(3);
        $user->permissions()->attach($permissions->random(rand(1, 3))->pluck('id')->toArray()); 
        
    }
}