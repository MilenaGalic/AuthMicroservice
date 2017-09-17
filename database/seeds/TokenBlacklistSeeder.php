<?php

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Seeder;

class TokenBlacklistSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        factory(App\TokenBlacklist::class)->create([
            'jti' => 'fake1-tRmhWLKwwfvdwwE6',
            'revocation_reason' => 'Faked revocation item'
        ]);

        factory(App\TokenBlacklist::class)->create([
            'jti' => 'fake2-tRmhWLKwwfvdwwE6',
            'revocation_reason' => 'Faked revocation item'
        ]);

        factory(App\TokenBlacklist::class)->create([
            'jti' => 'fake3-tRmhWLKwwfvdwwE6',
            'revocation_reason' => 'Faked revocation item'
        ]);

        factory(App\TokenBlacklist::class)->create([
            'jti' => 'fake4-tRmhWLKwwfvdwwE6',
            'revocation_reason' => 'Faked revocation item'
        ]);

        factory(App\TokenBlacklist::class)->create([
            'jti' => 'fake5-tRmhWLKwwfvdwwE6',
            'revocation_reason' => 'Faked revocation item'
        ]);

        factory(App\TokenBlacklist::class)->create([
            'jti' => 'fake6-tRmhWLKwwfvdwwE6',
            'revocation_reason' => 'Faked revocation item'
        ])
        
    }
}
