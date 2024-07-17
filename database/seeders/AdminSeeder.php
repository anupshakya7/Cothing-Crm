<?php

namespace Database\Seeders;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Database\Seeder;

class AdminSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        
        DB::table('users')->insert([
            'name' => 'Admin', // Extracting name from email
            'email' => 'admin@gmail.com',
            'username' => 'admin@gmail.com',
            'phone_no' => '9843840740',
            'password' => Hash::make('password'),
            'created_at' => date('Y-m-d H:i:s')
        ]);
    }
}
