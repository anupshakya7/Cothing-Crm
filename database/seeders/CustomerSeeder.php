<?php

namespace Database\Seeders;

use App\Models\Customer;
use Faker\Factory;
use Illuminate\Database\Seeder;

class CustomerSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $faker = Factory::create();
        for($i=0;$i<=10;$i++){
            Customer::create([
                'customer_name'=>$faker->name,
                'customer_contact_number'=>$faker->phoneNumber,
                'address'=>$faker->address,
                'email'=>$faker->unique()->safeEmail,
                'source'=>'Manual'
            ]); 
        }
    }
}
