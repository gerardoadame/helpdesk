<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class UserTypeSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {

        DB::table('user_type')->insert([
        	'type'=>'tecnico',
        ]);

        DB::table('user_type')->insert([
        	'type'=>'empleado',
        ]);
    }
}
