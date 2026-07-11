<?php

namespace Database\Seeders;

use App\Models\Branch;
use Illuminate\Database\Seeder;

class BranchSeeder extends Seeder
{
    public function run(): void
    {
        $branches = [
            [
                'name' => 'Samarinda',
                'code' => 'SMR',
                'address' => 'Jl. P. Diponegoro No. 1, Samarinda',
                'city' => 'Samarinda',
                'is_active' => true,
            ],
            [
                'name' => 'Samarinda Seberang',
                'code' => 'SDL',
                'address' => 'Jl. HM. Ardiansyah No. 10, Samarinda Seberang',
                'city' => 'Samarinda Seberang',
                'is_active' => true,
            ],
            [
                'name' => 'Palaran',
                'code' => 'PLR',
                'address' => 'Jl. Poros Palaran No. 5, Palaran',
                'city' => 'Palaran',
                'is_active' => true,
            ],
        ];

        foreach ($branches as $branch) {
            Branch::firstOrCreate(
                ['code' => $branch['code']],
                $branch
            );
        }

        $this->command->info('✅ '.count($branches).' cabang berhasil dibuat.');
    }
}
