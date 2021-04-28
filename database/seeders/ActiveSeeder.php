<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class ActiveSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('actives')->insert([
            'equipment'=>"laptop",
            'model'=>"pavilion",
            'features'=>"laptop hp pavilion con 12gb de RAM y almacenamiento dual, 128gb en ssd y 1tb en hdd",
            'purchase'=>"2019-03-22",
            'warranty'=>"2020-03-01",
            'serie'=>"qwerty1234567890",
            'stock'=>0,
            'provider_id'=>2,
            'payment_id'=>1
        ]);

        DB::table('actives')->insert([
            'equipment'=>"desktop",
            'model'=>"prodesk 600",
            'features'=>"computadora de escritorio intel core i5, 4gb de RAM y 500gb en disco duro",
            'purchase'=>"2018-03-22",
            'warranty'=>"2020-03-01",
            'serie'=>"qwertyuiop1234567890",
            'stock'=>0,
            'provider_id'=>2,
            'payment_id'=>1
        ]);

        DB::table('actives')->insert([
            'equipment'=>"desktop",
            'model'=>"All-in-one",
            'features'=>"computadora de escritorio hp con intel core pentium silver, 4gb en RAM y 1tb en disco duro",
            'purchase'=>"2018-09-12",
            'warranty'=>"2020-09-01",
            'serie'=>"asdfghj0987654321",
            'stock'=>1,
            'provider_id'=>2,
            'payment_id'=>2
        ]);
    }
}
