<?php

namespace Database\Seeders;

use App\Models\AcademicPeriod;
use App\Models\GradingPeriod;
use Illuminate\Database\Seeder;

class GradingPeriodSeeder extends Seeder
{
    public function run(): void
    {
        $now = now();

        // Búsquedas dinámicas para vincular las foráneas correctamente
        $primariaT1 = AcademicPeriod::where('educational_level_id', 2)->where('name', 'Trimestre 1')->first()?->id;
        $primariaT2 = AcademicPeriod::where('educational_level_id', 2)->where('name', 'Trimestre 2')->first()?->id;
        $primariaT3 = AcademicPeriod::where('educational_level_id', 2)->where('name', 'Trimestre 3')->first()?->id;

        $secundariaT1 = AcademicPeriod::where('educational_level_id', 3)->where('name', 'Trimestre 1')->first()?->id;
        $secundariaT2 = AcademicPeriod::where('educational_level_id', 3)->where('name', 'Trimestre 2')->first()?->id;
        $secundariaT3 = AcademicPeriod::where('educational_level_id', 3)->where('name', 'Trimestre 3')->first()?->id;

        $prepaS1 = AcademicPeriod::where('educational_level_id', 4)->where('name', 'Semestre 1')->first()?->id;
        $prepaS2 = AcademicPeriod::where('educational_level_id', 4)->where('name', 'Semestre 2')->first()?->id;

        $gradingPeriods = [
            // Primaria - Trimestres
            [
                'academic_period_id' => $primariaT1,
                'grading_period_type_id' => 2, // Unidad / Trimestre
                'name' => 'Evaluación Trimestre 1',
                'order' => 1,
                'status' => 'closed',
                'start_date' => '2025-09-01',
                'end_date' => '2025-11-28',
            ],
            [
                'academic_period_id' => $primariaT2,
                'grading_period_type_id' => 2,
                'name' => 'Evaluación Trimestre 2',
                'order' => 1,
                'status' => 'closed',
                'start_date' => '2025-12-01',
                'end_date' => '2026-03-27',
            ],
            [
                'academic_period_id' => $primariaT3,
                'grading_period_type_id' => 2,
                'name' => 'Evaluación Trimestre 3',
                'order' => 1,
                'status' => 'inProgress',
                'start_date' => '2026-04-13',
                'end_date' => '2026-07-15',
            ],

            // Secundaria - Trimestres
            [
                'academic_period_id' => $secundariaT1,
                'grading_period_type_id' => 2,
                'name' => 'Evaluación Trimestre 1',
                'order' => 1,
                'status' => 'closed',
                'start_date' => '2025-09-01',
                'end_date' => '2025-11-28',
            ],
            [
                'academic_period_id' => $secundariaT2,
                'grading_period_type_id' => 2,
                'name' => 'Evaluación Trimestre 2',
                'order' => 1,
                'status' => 'closed',
                'start_date' => '2025-12-01',
                'end_date' => '2026-03-27',
            ],
            [
                'academic_period_id' => $secundariaT3,
                'grading_period_type_id' => 2,
                'name' => 'Evaluación Trimestre 3',
                'order' => 1,
                'status' => 'inProgress',
                'start_date' => '2026-04-13',
                'end_date' => '2026-07-15',
            ],

            /*
            |--------------------------------------------------------------------------
            | EVALUACIONES PREPARATORIA (PARCIALES)
            |--------------------------------------------------------------------------
            */
            // Semestre 1 (Agosto - Diciembre 2025)
            [
                'academic_period_id' => $prepaS1,
                'grading_period_type_id' => 1,
                'name' => 'Parcial 1',
                'order' => 1,
                'status' => 'closed',
                'start_date' => '2025-08-25',
                'end_date' => '2025-09-30',
            ],
            [
                'academic_period_id' => $prepaS1,
                'grading_period_type_id' => 1,
                'name' => 'Parcial 2',
                'order' => 2,
                'status' => 'closed',
                'start_date' => '2025-10-01',
                'end_date' => '2025-11-10',
            ],
            [
                'academic_period_id' => $prepaS1,
                'grading_period_type_id' => 1,
                'name' => 'Parcial 3 / Ordinario',
                'order' => 3,
                'status' => 'closed',
                'start_date' => '2025-11-11',
                'end_date' => '2025-12-19',
            ],

            // Semestre 2 (Enero - Junio 2026)
            [
                'academic_period_id' => $prepaS2,
                'grading_period_type_id' => 1,
                'name' => 'Parcial 1',
                'order' => 1,
                'status' => 'closed',
                'start_date' => '2026-01-19',
                'end_date' => '2026-03-06',
            ],
            [
                'academic_period_id' => $prepaS2,
                'grading_period_type_id' => 1,
                'name' => 'Parcial 2',
                'order' => 2,
                'status' => 'closed',
                'start_date' => '2026-03-09',
                'end_date' => '2026-05-08',
            ],
            [
                'academic_period_id' => $prepaS2,
                'grading_period_type_id' => 1,
                'name' => 'Parcial 3 / Ordinario',
                'order' => 3,
                'status' => 'inProgress',
                'start_date' => '2026-05-11',
                'end_date' => '2026-06-26',
            ],
        ];

        // Filtrar nulos en caso de que algún nivel no esté presente
        $data = array_map(function ($item) use ($now) {
            return array_merge($item, [
                'created_at' => $now,
                'updated_at' => $now,
            ]);
        }, array_filter($gradingPeriods, fn($item) => !is_null($item['academic_period_id'])));

        GradingPeriod::insert($data);
    }
}
