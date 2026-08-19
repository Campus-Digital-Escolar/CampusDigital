<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class SportStageSeeder extends Seeder
{
    public function run(): void
    {
        $stages = [
            // Fases comunes de torneos/ligas
            ['name' => 'Fase Regular'],
            ['name' => 'Fase de Grupos'],
            ['name' => 'Dieciseisavos de Final'],
            ['name' => 'Octavos de Final'],
            ['name' => 'Cuartos de Final'],
            ['name' => 'Semifinal'],
            ['name' => 'Final'],
            ['name' => 'Tercer Puesto'],

            // Fases de calificación/tiempo
            ['name' => 'Clasificación (Qualy)'],
            ['name' => 'Eliminatorias'],
            ['name' => 'Preliminares'],
            ['name' => 'Repechaje'],

            // Fases de eventos individuales (Atletismo/Natación)
            ['name' => 'Series'],
            ['name' => 'Heats'],
            ['name' => 'Semifinal (Tiempo)'],
            ['name' => 'Final (Medalla)'],

            // Especiales (Ajedrez/Torneos Suizos)
            ['name' => 'Ronda Suiza'],
            ['name' => 'Play-offs'],
            ['name' => 'Consuelo']
        ];

        foreach ($stages as $stage) {
            DB::table('sport_stages')->updateOrInsert(
                ['name' => $stage['name']],
                ['created_at' => now(), 'updated_at' => now()]
            );
        }
    }
}
