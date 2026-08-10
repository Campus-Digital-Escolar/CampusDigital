<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class SubjectSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $subjects = [
            // ── PREESCOLAR (educational_level_id = 1) ─────────────────
            ['name' => 'Educación Socioemocional', 'educational_level_id' => 1],
            ['name' => 'Pensamiento Matemático Inicial', 'educational_level_id' => 1],
            ['name' => 'Lenguaje y Comunicación (Lectoescritura)', 'educational_level_id' => 1],
            ['name' => 'Exploración y Comprensión del Mundo Natural', 'educational_level_id' => 1],
            ['name' => 'Artes y Expresión Plástica', 'educational_level_id' => 1],
            ['name' => 'Educación Física y Psicomotricidad', 'educational_level_id' => 1],
            ['name' => 'Inglés Inicial', 'educational_level_id' => 1],

            // ── PRIMARIA (educational_level_id = 2) ────────────────────────────
            ['name' => 'Español (Lengua Materna)', 'educational_level_id' => 2],
            ['name' => 'Matemáticas', 'educational_level_id' => 2],
            ['name' => 'Ciencias Naturales', 'educational_level_id' => 2],
            ['name' => 'Historia de México', 'educational_level_id' => 2],
            ['name' => 'Geografía', 'educational_level_id' => 2],
            ['name' => 'Formación Cívica y Ética', 'educational_level_id' => 2],
            ['name' => 'Educación Artística', 'educational_level_id' => 2],
            ['name' => 'Educación Física', 'educational_level_id' => 2],
            ['name' => 'Inglés II', 'educational_level_id' => 2],
            ['name' => 'Computación Básica', 'educational_level_id' => 2],

            // ── SECUNDARIA (educational_level_id = 3) ──────────────────────────
            ['name' => 'Español e Literatura', 'educational_level_id' => 3],
            ['name' => 'Matemáticas III (Álgebra Básica)', 'educational_level_id' => 3],
            ['name' => 'Biología', 'educational_level_id' => 3],
            ['name' => 'Física General', 'educational_level_id' => 3],
            ['name' => 'Química Orgánica e Inorgánica', 'educational_level_id' => 3],
            ['name' => 'Historia Universal', 'educational_level_id' => 3],
            ['name' => 'Geografía Mundial', 'educational_level_id' => 3],
            ['name' => 'Formación Cívica y Ética II', 'educational_level_id' => 3],
            ['name' => 'Inglés Avanzado', 'educational_level_id' => 3],
            ['name' => 'Tecnología y Robótica', 'educational_level_id' => 3],
            ['name' => 'Artes (Música / Teatro)', 'educational_level_id' => 3],

            // ── PREPARATORIA / BACHILLERATO (educational_level_id = 4) ──────────
            ['name' => 'Álgebra y Geometría Analítica', 'educational_level_id' => 4],
            ['name' => 'Cálculo Diferencial e Integral', 'educational_level_id' => 4],
            ['name' => 'Física Clásica y Moderna', 'educational_level_id' => 4],
            ['name' => 'Química General y Analítica', 'educational_level_id' => 4],
            ['name' => 'Estructura Socioeconómica de México', 'educational_level_id' => 4],
            ['name' => 'Literatura Universal y Redacción', 'educational_level_id' => 4],
            ['name' => 'Filosofía y Ética Profesional', 'educational_level_id' => 4],
            ['name' => 'Metodología de la Investigación', 'educational_level_id' => 4],
            ['name' => 'Inglés para Negocios y Académico', 'educational_level_id' => 4],
            ['name' => 'Programación y Desarrollo Web', 'educational_level_id' => 4],
            ['name' => 'Orientación Vocacional', 'educational_level_id' => 4],
            ['name' => 'Biología Celular', 'educational_level_id' => 4],
        ];

        // Se añaden timestamps por convención del query builder directo
        $now = now();
        $data = array_map(function ($subject) use ($now) {
            return array_merge($subject, [
                'created_at' => $now,
                'updated_at' => $now,
            ]);
        }, $subjects);

        DB::table('subjects')->insert($data);

        // Tabla school-subject
        $subjectIds = DB::table('subjects')->pluck('id');
        $schoolId = 1;

        $pivotData = [];
        foreach ($subjectIds as $subjectId) {
            $pivotData[] = [
                'school_id'  => $schoolId,
                'subject_id' => $subjectId,
                'created_at' => $now,
                'updated_at' => $now,
            ];
        }

        DB::table('school_subject')->insert($pivotData);
    }
}
