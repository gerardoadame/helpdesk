<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class AreaSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('areas')->insert([
        	'name'=>'sistemas',
        ]);

        DB::table('areas')->insert([
        	'name'=>'administracion',
        ]);

        DB::table('areas')->insert([
        	'name'=>'recursos humanos',
        ]);

        DB::table('areas')->insert([
        	'name'=>'contaduria',
        ]);

        DB::table('areas')->insert([
        	'name'=>'produccion',
        ]);

        DB::table('areas')->insert([
        	'name'=>'marketing',
        ]);
        
    }
}
