<?php

namespace Database\Seeders;

use App\Models\Cell;
use Illuminate\Database\Seeder;

class CellSeeder extends Seeder
{
    public function run(): void
    {
        for ($i = 1; $i <= 3; $i++) {
            Cell::create([
                'cell_number' => 'S-' . $i,
                'type'        => 'small',
                'width'       => 30,
                'height'      => 20,
                'depth'       => 50,
                'status'      => 'active',
                'hardware_id' => 100 + $i,
                'cost'        => 50,
            ]);
        }

        for ($i = 1; $i <= 3; $i++) {
            Cell::create([
                'cell_number' => 'M-' . $i,
                'type'        => 'medium',
                'width'       => 45,
                'height'      => 45,
                'depth'       => 50,
                'status'      => 'active',
                'hardware_id' => 200 + $i,
                'cost'        => 100,
            ]);
        }

        for ($i = 1; $i <= 3; $i++) {
            Cell::create([
                'cell_number' => 'L-' . $i,
                'type'        => 'large',
                'width'       => 60,
                'height'      => 90,
                'depth'       => 60,
                'status'      => 'active',
                'hardware_id' => 300 + $i,
                'cost'        => 200,
            ]);
        }
    }
}
