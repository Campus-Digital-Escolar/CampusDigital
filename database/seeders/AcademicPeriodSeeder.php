<?php

namespace Database\Seeders;

use App\Models\AcademicPeriod;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class AcademicPeriodSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $now = now();

        $periods = [
            // PREESCOLAR
            ['school_year_id' => 1, 'educational_level_id' => 1, 'period_type_id' => 2, 'name' => 'Trimestre 1', 'order' => 1, 'start_date' => '2025-09-01', 'end_date' => '2025-11-28', 'active' => false],
            ['school_year_id' => 1, 'educational_level_id' => 1, 'period_type_id' => 2, 'name' => 'Trimestre 2', 'order' => 2, 'start_date' => '2025-12-01', 'end_date' => '2026-03-27', 'active' => false],
            ['school_year_id' => 1, 'educational_level_id' => 1, 'period_type_id' => 2, 'name' => 'Trimestre 3', 'order' => 3, 'start_date' => '2026-04-13', 'end_date' => '2026-07-15', 'active' => true],

            // PRIMARIA
            ['school_year_id' => 1, 'educational_level_id' => 2, 'period_type_id' => 2, 'name' => 'Trimestre 1', 'order' => 1, 'start_date' => '2025-09-01', 'end_date' => '2025-11-28', 'active' => false],
            ['school_year_id' => 1, 'educational_level_id' => 2, 'period_type_id' => 2, 'name' => 'Trimestre 2', 'order' => 2, 'start_date' => '2025-12-01', 'end_date' => '2026-03-27', 'active' => false],
            ['school_year_id' => 1, 'educational_level_id' => 2, 'period_type_id' => 2, 'name' => 'Trimestre 3', 'order' => 3, 'start_date' => '2026-04-13', 'end_date' => '2026-07-15', 'active' => true],

            // SECUNDARIA
            ['school_year_id' => 1, 'educational_level_id' => 3, 'period_type_id' => 2, 'name' => 'Trimestre 1', 'order' => 1, 'start_date' => '2025-09-01', 'end_date' => '2025-11-28', 'active' => false],
            ['school_year_id' => 1, 'educational_level_id' => 3, 'period_type_id' => 2, 'name' => 'Trimestre 2', 'order' => 2, 'start_date' => '2025-12-01', 'end_date' => '2026-03-27', 'active' => false],
            ['school_year_id' => 1, 'educational_level_id' => 3, 'period_type_id' => 2, 'name' => 'Trimestre 3', 'order' => 3, 'start_date' => '2026-04-13', 'end_date' => '2026-07-15', 'active' => true],

            // PREPARATORIA
            ['school_year_id' => 1, 'educational_level_id' => 4, 'period_type_id' => 4, 'name' => 'Semestre 1', 'order' => 1, 'start_date' => '2025-08-25', 'end_date' => '2025-12-19', 'active' => false],
            ['school_year_id' => 1, 'educational_level_id' => 4, 'period_type_id' => 4, 'name' => 'Semestre 2', 'order' => 2, 'start_date' => '2026-01-19', 'end_date' => '2026-06-26', 'active' => true],
        ];

        $data = array_map(function ($item) use ($now) {
            return array_merge($item, [
                'created_at' => $now,
                'updated_at' => $now,
            ]);
        }, $periods);

        AcademicPeriod::insert($data);
    }
}
