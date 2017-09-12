<?php

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Seeder;

class UsersTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        factory(App\User::class)->create([
        	'name' => 'Mark Manson',
        	'email' => 'example1@milanlatinovic.com',
        	'password' => app('hash')->make('1234')
        ]);

        factory(App\User::class)->create([
        	'name' => 'Milan Latinovic',
        	'email' => 'milan.softline@gmail.com',
        	'password' => app('hash')->make('admin')
        ]);

        factory(App\User::class)->create([
        	'name' => 'Markus Tscheik',
        	'email' => 'example3@google.com',
        	'password' => app('hash')->make('1234')
        ]);

    }
}
