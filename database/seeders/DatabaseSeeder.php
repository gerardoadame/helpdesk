<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        $this->call([
            AreaSeeder::class,
            UserSeeder::class,
            PersonSeeder::class,
            StatusSeeder::class,
            PrioritySeeder::class,
            Type_ticketSeeder::class,
            PaymentSeeder::class,
            ProviderSeeder::class,
            ActiveSeeder::class,
            Active_PersonSeeder::class,
        ]);
    }
}
