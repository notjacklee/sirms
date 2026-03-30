<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        // ✅ Seed statuses first
        $this->call([
            StatusSeeder::class,
        ]);

        // ✅ Admin
        User::updateOrCreate(
            ['email' => 'admin@example.com'],
            [
                'name' => 'Admin',
                'password' => Hash::make('password123'),
                'role' => 'admin',
            ]
        );

        // ✅ Reporter
        User::updateOrCreate(
            ['email' => 'reporter@example.com'],
            [
                'name' => 'Reporter',
                'password' => Hash::make('password123'),
                'role' => 'reporter',
            ]
        );

        // ✅ Officer 1
        User::updateOrCreate(
            ['email' => 'officer@example.com'],
            [
                'name' => 'Officer 1',
                'password' => Hash::make('password123'),
                'role' => 'officer',
            ]
        );
        // Officer 2
        User::updateOrCreate(
            ['email' => 'officer2@example.com'],
            [
                'name' => 'Officer 2',
                'password' => Hash::make('password123'),
                'role' => 'officer',
            ]
        );
    }
}