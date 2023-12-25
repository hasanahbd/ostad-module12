<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Trip;

class TripSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Trip::factory()->create([
            'origin_id' => 1,
            'destination_id' => 4,
            'date' => '2023-12-25',
        ]);
        Trip::factory()->create([
            'origin_id' => 1,
            'destination_id' => 3,
            'date' => '2023-12-26',
        ]);
    }
}
