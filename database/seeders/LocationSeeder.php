<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Location;

class LocationSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $cities=['Dhaka','Cumilla','Chittagong','Cox\'s Bazar'];
        foreach($cities as $city){
            Location::factory()->create([
                'name' => $city,
            ]);
        }
    }
}
