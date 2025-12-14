<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeder.
     */
    public function run(): void
    {
        // Create admin user
        User::create([
            'name' => 'Admin Magazijn',
            'email' => 'admin@jamin.nl',
            'password' => Hash::make('admin123'),
            'role' => 'admin',
        ]);

        // Create sample users with different roles
        User::create([
            'name' => 'Magazijnmedewerker',
            'email' => 'magazijn@jamin.nl',
            'password' => Hash::make('password'),
            'role' => 'magazijn medewerker',
        ]);

        User::create([
            'name' => 'Inkoper',
            'email' => 'inkoper@jamin.nl', 
            'password' => Hash::make('password'),
            'role' => 'inkoper',
        ]);

        User::create([
            'name' => 'Logistiek Medewerker',
            'email' => 'logistiek@jamin.nl',
            'password' => Hash::make('password'),
            'role' => 'logistiek medewerker',
        ]);


    }
}
