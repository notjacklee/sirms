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

        // admin
        User::factory()->create([
            'name' => 'Admin',
            'email' => 'admin@example.com',
            'password' => Hash::make('password123'),
            'role' => 'admin',
        ]);

        // reporter
        User::factory()->create([
            'name' => 'Reporter',
            'email' => 'reporter@example.com',
            'password' => Hash::make('password123'),
            'role' => 'reporter',
        ]);
    }
}
