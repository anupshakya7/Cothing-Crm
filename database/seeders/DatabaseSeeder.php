<?php

namespace Database\Seeders;

use Database\Seeders\SupplierSeeder;
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
            SupplierSeeder::class
        ]);
        // User::factory(10)->create();
    }
}
