<?php

namespace Database\Seeders;

use App\Models\OfficeLocation;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class OfficeLocationSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        OfficeLocation::create([
            'name' => 'JKB Main Office',
            'latitude' => -0.47902890,
            'longitude' => 117.1401699,
            'radius' => 100, // 100 meters radius for geofencing
            'address' => 'Jalan Delima Dalam, Blok E No.1'
        ]);
            
        $this->command->info('Office location created successfully!');
    }
}
