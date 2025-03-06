<?php

namespace Database\Seeders;

use App\Models\User;
// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // User::factory(100)->create();

        User::factory()->create([
            'name' => 'Gumukmas Admin',
            'email' => 'admin@gmail.com',
            'password' => '12345678',
            'address' => 'jl. Sultan Agung No.42, Dusun Krajan, Purwosari, Gumukmas, Jember',
        ]);
    }
}
