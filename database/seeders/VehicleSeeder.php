<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class VehicleSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $cityCar = \App\Models\VehicleCategory::where('name', 'City Car')->first();
        $mpv = \App\Models\VehicleCategory::where('name', 'MPV')->first();

        \App\Models\Vehicle::create([
            'category_id' => $cityCar->id,
            'name' => 'Honda Brio',
            'brand' => 'Honda',
            'license_plate' => 'B 1234 ABC',
            'price_per_day' => 250000,
            'status' => 'available',
        ]);

        \App\Models\Vehicle::create([
            'category_id' => $mpv->id,
            'name' => 'Toyota Avanza',
            'brand' => 'Toyota',
            'license_plate' => 'B 5678 DEF',
            'price_per_day' => 350000,
            'status' => 'available',
        ]);
        
        \App\Models\Vehicle::create([
            'category_id' => $mpv->id,
            'name' => 'Mitsubishi Xpander',
            'brand' => 'Mitsubishi',
            'license_plate' => 'D 9101 GHI',
            'price_per_day' => 400000,
            'status' => 'rented',
        ]);
    }
}
