<?php

namespace Database\Seeders;

use App\Models\Vendor;
use Faker\Factory;
use Illuminate\Database\Seeder;

class SupplierSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $faker = Factory::create();
        for($i=0;$i<=100;$i++){
            Vendor::create([
                'name'=>$faker->name,
                'contact_number'=> $faker->phoneNumber,
                'address'=> $faker->address,
                'status'=>'Active'
            ]);
        }
       
    }
}
