<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class Type_ticketSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('type_tickets')->insert([
            'type'=>'consumible'
        ]);
        
        DB::table('type_tickets')->insert([
            'type'=>'software'
        ]);
        
        DB::table('type_tickets')->insert([
            'type'=>'acceso y cuentas'
        ]);
        
        DB::table('type_tickets')->insert([
            'type'=>'servicios'
        ]);
        
        DB::table('type_tickets')->insert([
            'type'=>'hardware'
        ]);
        
    }
}
