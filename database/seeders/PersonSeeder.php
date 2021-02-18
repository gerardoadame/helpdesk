<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class PersonSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('persons')->insert([
        	'name'=>'juan',
        	'last_name'=>'espinoza',
        	'birth'=>'2000-01-01',
        	'address'=>"av del desierto #525",
        	'phone'=>"871xxxxxxx",
        	'employment'=>"ingeniero",
        	'user_id'=>1,
        	'area_id'=>1,
        ]);

        DB::table('persons')->insert([
            'name'=>'Enrique',
            'last_name'=>'de los santos',
            'birth'=>'2000-01-01',
            'address'=>"cerrada huizachal #78",
            'phone'=>"871xxxxxxx",
            'employment'=>"tecnico",
            'user_id'=>2,
            'area_id'=>1,
        ]);

        DB::table('persons')->insert([
            'name'=>'angel',
            'last_name'=>'lira',
            'birth'=>'1999-03-15',
            'address'=>"carolinas",
            'phone'=>"871xxxxxxx",
            'employment'=>"secretario",
            'user_id'=>3,
            'area_id'=>2,
        ]);
    }
}
