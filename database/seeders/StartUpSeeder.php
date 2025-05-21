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
            'name' => 'Admin',
            'email' => 'admin@gmail.com',
            'mobile_no' => '01811951216',
            'password' => bcrypt('25801379'),
            'type' => 'Admin',
            'username' => uniqid(),
        ]);
        $user = User::create([
            'name' => 'Developer',
            'email' => 'nmbabor50@gmail.com',
            'mobile_no' => '01811951215',
            'password' => bcrypt('124566'),
            'type' => 'Admin',
            'username' => uniqid(),
        ]);
    }
}
