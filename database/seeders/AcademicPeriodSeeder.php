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
        AcademicPeriod::create([
            'id' => 1,
            'school_year_id' => 1,
            'name' => 'Semestre 1',
            'start_date' => '2025-08-25',
            'end_date' => '2025-12-19'
        ]);

        AcademicPeriod::create([
            'id' => 2,
            'school_year_id' => 1,
            'name' => 'Semestre 2',
            'start_date' => '2025-01-06',
            'end_date' => '2025-06-05'
        ]);
    }
}
