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
        // el primer registro tiene el campo admin porqe en los demas sera por defecto 0
        DB::table('users')->insert([
        	'email'=>'juan@fimsa.com',
        	'password'=>Hash::make('12345678'),
            'admin'=>1,
        	'type_id'=>1,
        ]);

        DB::table('users')->insert([
            'email'=>'enrique@fimsa.com',
            'password'=>Hash::make('12345678'),
            'type_id'=>1,
        ]);

        DB::table('users')->insert([
            'email'=>'angel@fimsa.com',
            'password'=>Hash::make('12345678'),
            'type_id'=>2,
        ]);
    }
}
