<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\User;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        User::factory()->create([
            'name' => 'Md Ashickur Rahman',
            'email' => 'ashickur.noor@gmail.com',
            'role' => 'admin',
            'password' => '12345678',
        ]);
        User::factory()->create([
            'name' => 'Md Hasib Rahman',
            'email' => 'hasib@gmail.com',
            'role' => 'customer',
            'password' => '12345678',
        ]);
        User::factory()->count(10)->create();

    }
}
