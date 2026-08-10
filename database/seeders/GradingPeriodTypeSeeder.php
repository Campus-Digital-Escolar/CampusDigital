<?php

namespace Database\Seeders;

use App\Models\GradingPeriodType;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class GradingPeriodTypeSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $types = [
          ['name' => 'Parcial'],
          ['name' => 'Unidad'],
          ['name' => 'Proyecto'],
          ['name' => 'Examen Final'],
          ['name' => 'Ordinario'],
          ['name' => 'Extraordinario'],
        ];

        $now = now();
        $data = array_map(function ($type) use ($now) {
            return array_merge($type, [
                'created_at' => $now,
                'updated_at' => $now,
            ]);
        }, $types);

        GradingPeriodType::insert($data);
    }
}
