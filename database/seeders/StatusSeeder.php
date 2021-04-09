<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class StatusSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('statuses')->insert([
            'status'=>'cerrado'
        ]);

        DB::table('statuses')->insert([
            'status'=>'en proceso'
        ]);

        DB::table('statuses')->insert([
            'status'=>'abierto'
        ]);

        DB::table('statuses')->insert([
            'status'=>'atrasado'
        ]);
        
    }
}
