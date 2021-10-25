<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('users')->insert([
            [
                'email' => 'juan@fimsa.com',
                'password' => Hash::make('12345678'),
                'admin' => true,
                'person_id' => 1,
            ], [
                'email' => 'enrique@fimsa.com',
                'password' => Hash::make('12345678'),
                'admin' => false,
                'person_id' => 2,
            ], [
                'email' => 'juaangel.rey@gmail.com',
                'password' => Hash::make('12345678'),
                'admin' => false,
                'person_id' => 3,
            ]
        ]);
    }
}
