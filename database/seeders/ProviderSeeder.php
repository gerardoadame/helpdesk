<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class ProviderSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('providers')->insert([
            'company'=>"megacable",
            'contact'=>"juan manuel",
            'phone'=>"871xxxxxxx",
            'cellphone'=>"871xxxxxxx",
            'address'=>"av. Hidalgo"
        ]);

        DB::table('providers')->insert([
            'company'=>"HP",
            'contact'=>"juan gandarilla",
            'phone'=>"871xxxxxxx",
            'cellphone'=>"871xxxxxxx",
            'address'=>"blvd. Independencia"
        ]);

        DB::table('providers')->insert([
            'company'=>"Microsoft",
            'contact'=>"juan francisco",
            'phone'=>"871xxxxxxx",
            'cellphone'=>"871xxxxxxx",
            'address'=>"carretera torreon-matamoros"
        ]);
    }
}
