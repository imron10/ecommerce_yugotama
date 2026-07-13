<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        User::firstOrCreate(
            ['email' => 'admin@yugotama.com'],
            [
                'name' => 'Admin Toko',
                'password' => bcrypt('password123'),
                'role' => 'admin',
            ]
        );

        User::firstOrCreate(
            ['email' => 'test@example.com'],
            [
                'name' => 'Test User',
                'password' => bcrypt('password123'),
                'role' => 'buyer',
            ]
        );

        $this->call([
            CategorySeeder::class,
            ProductSeeder::class,
            // Note: PromoSeeder & OrderSeeder akan diaktifkan di fase terkait (Fase 1+)
        ]);
    }
}
