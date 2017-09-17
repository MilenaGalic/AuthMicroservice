<?php

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Seeder;

class PermissionsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        factory(App\Permission::class)->create([
            'name' => 'CREATE_USER',
            'description' => 'Permission to create another user accounts.'
        ]);

        factory(App\Permission::class)->create([
            'name' => 'DELETE_USER',
            'description' => 'Permission to delete another user accounts.'
        ]);

        factory(App\Permission::class)->create([
            'name' => 'CREATE_PERMISSION',
            'description' => 'Permission to create permissions.'
        ]);

        factory(App\Permission::class)->create([
            'name' => 'ASSIGN_PERMISSION',
            'description' => 'Permission to assign permissions to other user accounts.'
        ]);

        factory(App\Permission::class)->create([
            'name' => 'REMOVE_PERMISSION',
            'description' => 'Permission to remove permissions from other user accounts.'
        ]);

        factory(App\Permission::class)->create([
            'name' => 'DELETE_PERMISSION',
            'description' => 'Permission to delete permissions.'
        ]);
    }
}
