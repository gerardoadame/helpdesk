<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class PrioritySeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('priorities')->insert([
            'priority'=>'baja'
        ]);

        DB::table('priorities')->insert([
            'priority'=>'media'
        ]);

        DB::table('priorities')->insert([
            'priority'=>'alta'
        ]);

        DB::table('priorities')->insert([
            'priority'=>'urgente'
        ]);

    }
}
