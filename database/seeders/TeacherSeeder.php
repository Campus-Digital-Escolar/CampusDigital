<?php

namespace Database\Seeders;

use App\Models\JobPosition;
use App\Models\Teacher;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class TeacherSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $teachersData = [
            // --- PREESCOLAR ---
            [
                'school_id' => 1,
                'title' => 'Lic.',
                'name' => 'Mariana',
                'lastname' => 'Gómez Peralta',
                'job_position_id' => 4,
                'profession' => 'Lic. en Educación Preescolar',
            ],
            [
                'school_id' => 1,
                'title' => 'Prof.',
                'name' => 'Sofía',
                'lastname' => 'Hernández Castro',
                'job_position_id' => 10,
                'profession' => 'Lic. en Pedagogía',
            ],
            [
                'school_id' => 1,
                'title' => 'Lic.',
                'name' => 'Laura',
                'lastname' => 'Vargas Méndez',
                'job_position_id' => 12,
                'profession' => 'Lic. en Educación Inicial',
            ],

            // --- PRIMARIA ---
            [
                'school_id' => 1,
                'title' => 'Mtr.',
                'name' => 'Carlos',
                'lastname' => 'Martínez Ruiz',
                'job_position_id' => 5,
                'profession' => 'Maestría en Gestión Educativa',
            ],
            [
                'school_id' => 1,
                'title' => 'Prof.',
                'name' => 'Ana Beatriz',
                'lastname' => 'López Morales',
                'job_position_id' => 10,
                'profession' => 'Lic. en Educación Primaria',
            ],
            [
                'school_id' => 1,
                'title' => 'Lic.',
                'name' => 'Fernando',
                'lastname' => 'Torres Delgado',
                'job_position_id' => 11,
                'profession' => 'Lic. en Educación Física',
            ],

            // --- SECUNDARIA ---
            [
                'school_id' => 1,
                'title' => 'Lic.',
                'name' => 'Roberto',
                'lastname' => 'Navarro Silva',
                'job_position_id' => 6,
                'profession' => 'Lic. en Ciencias de la Educación',
            ],
            [
                'school_id' => 1,
                'title' => 'Ing.',
                'name' => 'Alejandro',
                'lastname' => 'Sánchez Reyes',
                'job_position_id' => 11,
                'profession' => 'Ingeniero Químico',
            ],
            [
                'school_id' => 1,
                'title' => 'Mtr.',
                'name' => 'Claudia',
                'lastname' => 'Ortega Jiménez',
                'job_position_id' => 14,
                'profession' => 'Lic. en Psicología Educativa',
            ],
            [
                'school_id' => 1,
                'title' => 'Prof.',
                'name' => 'Gabriel',
                'lastname' => 'Mendoza Ríos',
                'job_position_id' => 13,
                'profession' => 'Lic. en Sociología',
            ],

            // --- PREPARATORIA ---
            [
                'school_id' => 1,
                'title' => 'Dr.',
                'name' => 'Enrique',
                'lastname' => 'Villanueva Peña',
                'job_position_id' => 7,
                'profession' => 'Doctorado en Educación',
            ],
            [
                'school_id' => 1,
                'title' => 'Ing.',
                'name' => 'Diana Marcela',
                'lastname' => 'García Cordero',
                'job_position_id' => 11,
                'profession' => 'Ingeniera en Sistemas Computacionales',
            ],
            [
                'school_id' => 1,
                'title' => 'Lic.',
                'name' => 'Javier',
                'lastname' => 'Espinosa Blanco',
                'job_position_id' => 17,
                'profession' => 'Lic. en Biología',
            ],
        ];

        foreach ($teachersData as $teacher) {

            Teacher::updateOrCreate(
                [
                    'name' => $teacher['name'],
                    'lastname' => $teacher['lastname'],
                ],
                [
                    'school_id' => $teacher['school_id'],
                    'user_id' => null,
                    'job_position_id' => $teacher['job_position_id'],
                    'title' => $teacher['title'],
                    'profession' => $teacher['profession'],
                    'photo_path' => null,
                ]
            );
        }
    }
}
