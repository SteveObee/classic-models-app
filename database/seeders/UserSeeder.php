<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('users')->insert([
            'name' => 'FreyreDiego17',
            'email' => 'freyred@esc.com',
            'password' => Hash::make('24@-!AaJhP-ErXH'),
            'customer_id' => 141
        ]);

        DB::table('users')->insert([
            'name' => 'SteveAdmin',
            'email' => 'steve@classicmodels.com',
            'password' => Hash::make('cjyFQ*9$=4_X7ij')
        ]);
    }
}
