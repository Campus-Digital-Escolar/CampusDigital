<?php

namespace Database\Seeders;

use App\Models\Group;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class GroupSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Group::insert([
            // Prescolar 1°
            ['group_grade_id' => 1, 'section' => 'A'],
            ['group_grade_id' => 1, 'section' => 'B'],

            // Prescolar 2°
            ['group_grade_id' => 2, 'section' => 'A'],
            ['group_grade_id' => 2, 'section' => 'B'],

            // Prescolar 3°
            ['group_grade_id' => 3, 'section' => 'A'],
            ['group_grade_id' => 3, 'section' => 'B'],

            // Primaria 1°
            ['group_grade_id' => 4, 'section' => 'A'],
            ['group_grade_id' => 4, 'section' => 'B'],

            // Primaria 2°
            ['group_grade_id' => 5, 'section' => 'A'],
            ['group_grade_id' => 5, 'section' => 'B'],

            // Primaria 3°
            ['group_grade_id' => 6, 'section' => 'A'],
            ['group_grade_id' => 6, 'section' => 'B'],

            // Primaria 4°
            ['group_grade_id' => 7, 'section' => 'A'],
            ['group_grade_id' => 7, 'section' => 'B'],

            // Primaria 5°
            ['group_grade_id' => 8, 'section' => 'A'],
            ['group_grade_id' => 8, 'section' => 'B'],

            // Primaria 6°
            ['group_grade_id' => 9, 'section' => 'A'],
            ['group_grade_id' => 9, 'section' => 'B'],

            // Secundaria 1°
            ['group_grade_id' => 10, 'section' => 'A'],
            ['group_grade_id' => 10, 'section' => 'B'],

            // Secundaria 1°
            ['group_grade_id' => 11, 'section' => 'A'],
            ['group_grade_id' => 11, 'section' => 'B'],

            // Secundaria 1°
            ['group_grade_id' => 12, 'section' => 'A'],
            ['group_grade_id' => 12, 'section' => 'B'],

            // Preparatoria Semestre 1
            ['group_grade_id' => 13, 'section' => 'A'],
            ['group_grade_id' => 13, 'section' => 'B'],

            // Preparatoria Semestre 2
            ['group_grade_id' => 14, 'section' => 'A'],
            ['group_grade_id' => 14, 'section' => 'B'],

            // Preparatoria Semestre 3
            ['group_grade_id' => 15, 'section' => 'A'],
            ['group_grade_id' => 15, 'section' => 'B'],

            // Preparatoria Semestre 4
            ['group_grade_id' => 16, 'section' => 'A'],
            ['group_grade_id' => 16, 'section' => 'B'],

            // Preparatoria Semestre 5
            ['group_grade_id' => 17, 'section' => 'A'],
            ['group_grade_id' => 17, 'section' => 'B'],

            // Preparatoria Semestre 6
            ['group_grade_id' => 18, 'section' => 'A'],
            ['group_grade_id' => 18, 'section' => 'B'],
        ]);
    }
}
