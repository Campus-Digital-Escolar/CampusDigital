<?php

namespace Database\Seeders;

use App\Models\GroupGrade;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class GroupGradeSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $grades = [
            // Preescolar
            ['educational_level_id' => 1, 'name' => '1°', 'order' => 1],
            ['educational_level_id' => 1, 'name' => '2°', 'order' => 2],
            ['educational_level_id' => 1, 'name' => '3°', 'order' => 3],

            // Primaria
            ['educational_level_id' => 2, 'name' => '1°', 'order' => 1],
            ['educational_level_id' => 2, 'name' => '2°', 'order' => 2],
            ['educational_level_id' => 2, 'name' => '3°', 'order' => 3],
            ['educational_level_id' => 2, 'name' => '4°', 'order' => 4],
            ['educational_level_id' => 2, 'name' => '5°', 'order' => 5],
            ['educational_level_id' => 2, 'name' => '6°', 'order' => 6],

            // Secundaria
            ['educational_level_id' => 3, 'name' => '1°', 'order' => 1],
            ['educational_level_id' => 3, 'name' => '2°', 'order' => 2],
            ['educational_level_id' => 3, 'name' => '3°', 'order' => 3],

            // Preparatoria
            ['educational_level_id' => 4, 'name' => '1°', 'order' => 1],
            ['educational_level_id' => 4, 'name' => '2°', 'order' => 2],
            ['educational_level_id' => 4, 'name' => '3°', 'order' => 3],
            ['educational_level_id' => 4, 'name' => '4°', 'order' => 4],
            ['educational_level_id' => 4, 'name' => '5°', 'order' => 5],
            ['educational_level_id' => 4, 'name' => '6°', 'order' => 6],
        ];

        // Se añaden timestamps por convención del query builder directo
        $now = now();
        $data = array_map(function ($grade) use ($now) {
            return array_merge($grade, [
                'created_at' => $now,
                'updated_at' => $now,
            ]);
        }, $grades);

        GroupGrade::insert($data);
    }
}
