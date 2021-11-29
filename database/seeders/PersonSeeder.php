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
            [
                'name' => 'Juan Enrique',
                'last_name' => 'Espinoza De Los Santos',
                'email' => 'juan@fimsa.com',
                'birth' => '2000-01-01',
                'address' => "av del desierto #525",
                'phone' => "871xxxxxxx",
                'employment' => "ingeniero",
                'area_id' => null,
                'is_agent' => true
            ], [
                'name' => 'Juan Gerardo',
                'last_name' => 'Adame Torres',
                'email' => 'elgeras@otro.com',
                'birth' => '2000-01-01',
                'address' => "cerrada huizachal #78",
                'phone' => "871xxxxxxx",
                'employment' => "tecnico",
                'area_id' => null,
                'is_agent' => true
            ], [
                'name' => 'Juan Angel',
                'last_name' => 'Reyes Lira',
                'email' => 'juaangel.rey@gmail.com',
                'birth' => '1999-03-15',
                'address' => "carolinas",
                'phone' => "871xxxxxxx",
                'employment' => "chingon",
                'area_id' => null,
                'is_agent' => false
            ], [
                'name' => 'Andres Manuel',
                'last_name' => 'Lopéz Obrador',
                'email' => null,
                'birth' => '1999-03-15',
                'address' => "carolinas",
                'phone' => "871xxxxxxx",
                'employment' => "Presidente de la república",
                'area_id' => null,
                'is_agent' => false
            ]
        ]);
    }
}
