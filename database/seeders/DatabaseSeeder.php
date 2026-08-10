<?php

namespace Database\Seeders;

use App\Models\PostTagCatalog;
use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    use WithoutModelEvents;

    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        $this->call([
            SchoolSeeder::class,
            EducationalLevelSeeder::class,
            RoleSeeder::class,
            JobPositionSeeder::class,
            TeacherSeeder::class,
            UserSeeder::class,
            SchoolYearSeeder::class,
            PeriodTypeSeeder::class,
            GradingPeriodTypeSeeder::class,
            GroupGradeSeeder::class,
            GroupSeeder::class,
            AcademicPeriodSeeder::class,
            GradingPeriodSeeder::class,
            SubjectSeeder::class,
            PostTagCatalogSeeder::class,
        ]);
    }
}
