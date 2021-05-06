<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class Active_PersonSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('active_person')->insert([
            'active_id'=>1,
            'person_id'=>1,
            'assignment'=>"2019-03-22"
        ]);

        DB::table('active_person')->insert([
            'active_id'=>2,
            'person_id'=>2,
            'assignment'=>"2018-03-22"
        ]);

        DB::table('active_person')->insert([
            'active_id'=>3,
            'person_id'=>3,
            'assignment'=>"2018-09-12"
        ]);
    }
}
