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
        	'email'=>'juan@gmail@fimsa.com',
        	'password'=>Hash::make('12345'),
        	'type_id'=>1,
        ]);

        DB::table('users')->insert([
            'email'=>'enrique@gmail@fimsa.com',
            'password'=>Hash::make('12345'),
            'type_id'=>2,
        ]);

        DB::table('users')->insert([
            'email'=>'angel@gmail@fimsa.com',
            'password'=>Hash::make('12345'),
            'type_id'=>3,
        ]);
    }
}
