<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        User::create([
            'name' => 'Admin',
            'email' => 'admin@gmail.com',
            'password' => bcrypt('password'),
            'gender' => 'L',
            'birth_year' => '2000',
            'is_admin' => true,
        ]);
        User::create([
            'name' => 'Nauni',
            'email' => 'nauni@gmail.com',
            'password' => bcrypt('password'),
            'gender' => 'L',
            'birth_year' => '2000'
        ]);

    }
}
