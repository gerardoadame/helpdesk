<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
    	$this->truncateTables([
    		'user_type',
    		'areas',
    		'users',
    		'persons',
            'statuses',
            'priorities',
            'type_tickets',
            'payments',
            'providers',
            'actives',
    	]);

        // \App\Models\User::factory(10)->create();
        $this->call(UserTypeSeeder::class);
        $this->call(AreaSeeder::class);
        $this->call(UserSeeder::class);
        $this->call(PersonSeeder::class);
        $this->call(StatusSeeder::class);
        $this->call(PrioritySeeder::class);
        $this->call(Type_ticketSeeder::class);
        $this->call(PaymentSeeder::class);
        $this->call(ProviderSeeder::class);
        $this->call(ActiveSeeder::class);
    }

    protected function truncateTables(array $tables){
    	DB::statement('SET FOREIGN_KEY_CHECKS = 0;');

    	foreach ($tables as $table) {
    		DB::table($table)->truncate();
    	}
    	
    	DB::statement('SET FOREIGN_KEY_CHECKS = 1;');
    }
}
