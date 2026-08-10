<?php

namespace Database\Seeders;

use App\Models\EducationalLevel;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class EducationalLevelSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        EducationalLevel::create([
            'id' => 1,
            'name' => 'Preescolar',
        ]);

        EducationalLevel::create([
            'id' => 2,
            'name' => 'Primaria',
        ]);

        EducationalLevel::create([
            'id' => 3,
            'name' => 'Secundaria',
        ]);

        EducationalLevel::create([
            'id' => 4,
            'name' => 'Preparatoria',
        ]);
    }
}
