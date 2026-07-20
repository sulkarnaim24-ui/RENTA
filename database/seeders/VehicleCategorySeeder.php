<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class VehicleCategorySeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $categories = [
            ['name' => 'City Car', 'description' => 'Mobil kecil untuk dalam kota'],
            ['name' => 'MPV', 'description' => 'Multi Purpose Vehicle untuk keluarga'],
            ['name' => 'SUV', 'description' => 'Sport Utility Vehicle'],
            ['name' => 'Motor', 'description' => 'Kendaraan roda dua'],
        ];

        foreach ($categories as $cat) {
            \App\Models\VehicleCategory::create($cat);
        }
    }
}
