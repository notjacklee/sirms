<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        $this->call([
            StatusSeeder::class,
        ]);

        // Admin
        User::create([
            'name' => 'Admin',
            'email' => 'admin@example.com',
            'password' => Hash::make('password123'),
            'role' => 'admin',
        ]);

        // Reporter
        User::create([
            'name' => 'Reporter',
            'email' => 'reporter@example.com',
            'password' => Hash::make('password123'),
            'role' => 'reporter',
        ]);

        // Officer
        User::create([
            'name' => 'Officer',
            'email' => 'officer@example.com',
            'password' => Hash::make('password123'),
            'role' => 'officer',
        ]);
    }
}