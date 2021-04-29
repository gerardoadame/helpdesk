<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class PaymentSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('payments')->insert([
            'payment'=>'pago unico'
        ]);

        DB::table('payments')->insert([
            'payment'=>'mensual'
        ]);

        DB::table('payments')->insert([
            'payment'=>'anual'
        ]);
    }
}
