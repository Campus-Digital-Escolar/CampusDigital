<?php

namespace Database\Seeders;

use App\Models\Role;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class RoleSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Role::create(
            ['id' => 1, 'name' => 'empresa', 'slug' => 'company']
        );

        Role::create(
            ['id' => 2, 'name' => 'Administrador', 'slug' => 'admin']
        );

        Role::create(
            ['id' => 3, 'name' => 'Docente', 'slug' => 'teacher']
        );

        Role::create(
            ['id' => 4, 'name' => 'Padre_de_familia', 'slug' => 'parent']
        );

        Role::create(
            ['id' => 5, 'name' => 'Estudiante', 'slug' => 'student']
        );
    }
}
