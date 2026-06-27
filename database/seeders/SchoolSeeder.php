<?php

namespace Database\Seeders;

use App\Models\School;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class SchoolSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        School::create([
            'id' => 1,
            'name' => 'Escuela Prueba',
            'campus' => 'Norte',
            'address' => 'Direccion de prueba',
            'logo_path' => 'logoPrueba.svg'
        ]);
    }
}
