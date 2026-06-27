<?php

namespace Database\Seeders;

use App\Models\SchoolYear;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class SchoolYearSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        SchoolYear::create(
            [
                'id' => 1,
                'name' => '2025-2026',
                'start_date' => '2025-08-25',
                'end_date' => '2026-06-05',
                'active' => true
            ]
        );

        SchoolYear::create(
            [
                'id' => 2,
                'name' => '2026-2027',
                'start_date' => '2026-08-31',
                'end_date' => '2026-07-17',
                'active' => false
            ]
        );
    }
}
