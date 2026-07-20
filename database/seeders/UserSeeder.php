<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $users = [
            [
                'name' => 'Admin Renta',
                'email' => 'admin@gmail.com',
                'role' => 'admin',
                'phone' => '081234567890',
                'address' => 'Jl. Admin Renta No. 1',
            ],
            [
                'name' => 'Customer Renta',
                'email' => 'customer@gmail.com',
                'role' => 'customer',
                'phone' => '081298765432',
                'address' => 'Jl. Customer Renta No. 2',
            ],
        ];

        foreach ($users as $user) {
            if (User::where('email', $user['email'])->exists()) {
                continue;
            }

            User::factory()->create([
                'name' => $user['name'],
                'email' => $user['email'],
                'role' => $user['role'],
                'phone' => $user['phone'],
                'address' => $user['address'],
            ]);
        }
    }
}
