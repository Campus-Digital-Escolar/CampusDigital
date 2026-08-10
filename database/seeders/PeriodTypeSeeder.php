<?php

namespace Database\Seeders;

use App\Models\PeriodType;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class PeriodTypeSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $types = [
            ['name' => 'Bimestre'],
            ['name' => 'Trimestre'],
            ['name' => 'Cuatrimestre'],
            ['name' => 'Semestre'],
            ['name' => 'Anual'],
        ];

        $now = now();
        $data = array_map(function ($type) use ($now) {
            return array_merge($type, [
                'created_at' => $now,
                'updated_at' => $now,
            ]);
        }, $types);

        PeriodType::insert($data);
    }
}
