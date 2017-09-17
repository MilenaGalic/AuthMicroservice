<?php

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Seeder;

use App\User;
use App\Permission;

class SuperAdminSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {

        $permissions = App\Permission::all();
        $user = User::find(1);
        $user->permissions()->attach($permissions->pluck('id')->toArray()); 

    }
}
