<?php

namespace Database\Seeders;

use App\Models\JobPosition;
use Illuminate\Database\Seeder;

class JobPositionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $positions = [
            // Dirección y Subdirección
            ['name' => 'Director(a) General', 'department' => 'Dirección General'],
            ['name' => 'Director(a) Académico(a)', 'department' => 'Dirección Académica'],
            ['name' => 'Subdirector(a)', 'department' => 'Dirección'],

            // Coordinaciones por Nivel Educativo
            ['name' => 'Coordinador(a) de Preescolar', 'department' => 'Coordinación Académica'],
            ['name' => 'Coordinador(a) de Primaria', 'department' => 'Coordinación Académica'],
            ['name' => 'Coordinador(a) de Secundaria', 'department' => 'Coordinación Académica'],
            ['name' => 'Coordinador(a) de Preparatoria', 'department' => 'Coordinación Académica'],
            ['name' => 'Coordinador(a) de Idiomas', 'department' => 'Coordinación Académica'],
            ['name' => 'Coordinador(a) de Tecnología', 'department' => 'Sistemas y Tecnología'],

            // Puestos Docentes y de Apoyo Operativo
            ['name' => 'Docente Titular', 'department' => 'Académico'],
            ['name' => 'Docente de Asignatura', 'department' => 'Académico'],
            ['name' => 'Docente Auxiliar / Asistente', 'department' => 'Académico'],
            ['name' => 'Prefecto(a)', 'department' => 'Disciplina y Servicios Escolares'],
            ['name' => 'Orientador(a) Educativo(a)', 'department' => 'Orientación Psicopedagógica'],
            ['name' => 'Psicologo(a)', 'department' =>'Orientación Psicopedagógica'],
            ['name' => 'Bibliotecario(a)', 'department' => 'Servicios Académicos'],
            ['name' => 'Encargado(a) de Laboratorio', 'department' => 'Académico'],
        ];

        foreach ($positions as $position) {
            JobPosition::updateOrCreate(
                ['name' => $position['name']],
                ['department' => $position['department']]
            );
        }
    }
}
