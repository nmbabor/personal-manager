<?php

namespace Database\Seeders;

use App\Models\Country;
use App\Models\User;
use App\Models\Setting;
use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Role;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;

class StartUpSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {

        $user = User::create([
            'name' => 'Mr Admin',
            'email' => 'admin@gmail.com',
            'mobile_no' => '01811951216',
            'country_id' => 1,
            'password' => bcrypt('12345678'),
            'type' => 'Admin',
            'username' => uniqid(),
            'designation' => "Admin",
            'join_date' => date('Y-m-d'),
            'deposit_start_date' => date('Y-m-d'),
        ]);

        $countries = ['Bangladesh','Oman','Saudi Arabia','Bahrain','Qatar','Kuwait','Italy','Singapore','Malaysia','United Arab Emirates','Dubai','Chaina','South Africa','Abu Dhabi'];
        foreach($countries as $country){
            Country::create([
                'name' => $country
            ]);
        }
    }
}
