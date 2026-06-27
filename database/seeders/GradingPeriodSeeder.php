<?php

namespace Database\Seeders;

use App\Models\GradingPeriod;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class GradingPeriodSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        GradingPeriod::insert(
            ['id' => 1, 'academic_period_id' => 1, 'name' => 'Parcial 1', 'start_date' => '2025-08-25', 'end_date' => '2025-09-26']
        );

        GradingPeriod::insert(
            ['id' => 2, 'academic_period_id' => 1, 'name' => 'Parcial 2', 'start_date' => '2025-09-29', 'end_date' => '2025-11-07']
        );

        GradingPeriod::insert(
            ['id' => 3, 'academic_period_id' => 1, 'name' => 'Parcial 3', 'start_date' => '2025-11-10', 'end_date' => '2025-12-19']
        );

        GradingPeriod::insert(
            ['id' => 4, 'academic_period_id' => 1, 'name' => 'Parcial 1', 'start_date' => '2026-01-07', 'end_date' => '2026-02-20']
        );

        GradingPeriod::insert(
            ['id' => 5, 'academic_period_id' => 1, 'name' => 'Parcial 2', 'start_date' => '2026-02-23', 'end_date' => '2026-04-24']
        );

        GradingPeriod::insert(
            ['id' => 6, 'academic_period_id' => 1, 'name' => 'Parcial 3', 'start_date' => '2026-04-27', 'end_date' => '2026-06-05']
        );
    }
}
