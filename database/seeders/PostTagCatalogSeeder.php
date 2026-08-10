<?php

namespace Database\Seeders;

use App\Models\PostTagCatalog;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class PostTagCatalogSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $values = [
            'Respeto',
            'Honestidad',
            'Responsabilidad',
            'Empatía',
            'Solidaridad',
            'Tolerancia',
            'Perseverancia',
            'Gratitud',
            'Compañerismo',
            'Trabajo en equipo',
            'Justicia',
            'Humildad',
        ];

        $emotions = [
            'Entusiasmado',
            'Orgulloso',
            'Agradecido',
            'Inspirado',
            'Motivado',
            'Feliz',
            'Unido',
            'Tranquilo',
            'Optimista',
            'Satisfecho',
        ];

        foreach ($values as $value) {
            PostTagCatalog::updateOrCreate(
                ['name' => $value],
                ['type' => 'value']
            );
        }

        foreach ($emotions as $emotion) {
            PostTagCatalog::updateOrCreate(
                ['name' => $emotion],
                ['type' => 'emotion']
            );
        }
    }
}
