<?php

namespace Database\Seeders;

use App\Models\Student;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class StudentSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $students = [
            [
                'user_id'       => null,
                'name'          => 'Julieta',
                'lastname'      => 'Parras Gutierrez',
                'birthday'      => '2009-03-12',
                'gender'        => 'female',
                'photo_path'    => null,
                'grade_average' => 0.0,
                'created_at'    => '2026-07-20 20:28:04',
                'updated_at'    => '2026-07-20 20:28:04',
            ],
            [
                'user_id'       => null,
                'name'          => 'Josue',
                'lastname'      => 'Garcia López',
                'birthday'      => '2009-09-12',
                'gender'        => 'male',
                'photo_path'    => null,
                'grade_average' => 0.0,
                'created_at'    => '2026-07-20 21:13:19',
                'updated_at'    => '2026-07-20 21:13:19',
            ],
            [
                'user_id'       => null,
                'name'          => 'Javier',
                'lastname'      => 'Ramirez Soto',
                'birthday'      => '2013-05-12',
                'gender'        => 'male',
                'photo_path'    => null,
                'grade_average' => 0.0,
                'created_at'    => '2026-07-20 21:51:20',
                'updated_at'    => '2026-07-20 21:51:20',
            ],
            [
                'user_id'       => null,
                'name'          => 'Luis',
                'lastname'      => 'Soto Escaleras',
                'birthday'      => '2013-05-24',
                'gender'        => 'male',
                'photo_path'    => null,
                'grade_average' => 0.0,
                'created_at'    => '2026-07-20 21:54:07',
                'updated_at'    => '2026-07-20 21:54:07',
            ],
            [
                'user_id'       => null,
                'name'          => 'Carla',
                'lastname'      => 'Perez Solis',
                'birthday'      => '2019-01-23',
                'gender'        => 'female',
                'photo_path'    => null,
                'grade_average' => 0.0,
                'created_at'    => '2026-07-20 22:57:46',
                'updated_at'    => '2026-07-20 22:57:46',
            ],
            [
                'user_id'       => null,
                'name'          => 'Emmanuel',
                'lastname'      => 'Aguirre Lira',
                'birthday'      => '2022-06-24',
                'gender'        => 'male',
                'photo_path'    => 'students/photos/WKcIsWsWK1ZCFFnvbR36vBLj24fveD97rHZujdhH.jpg',
                'grade_average' => 0.0,
                'created_at'    => '2026-07-20 22:59:26',
                'updated_at'    => '2026-07-20 23:03:42',
            ],
            [
                'user_id'       => null,
                'name'          => 'Rebecca',
                'lastname'      => 'Lara Sifuentes',
                'birthday'      => '2022-02-11',
                'gender'        => 'female',
                'photo_path'    => null,
                'grade_average' => 0.0,
                'created_at'    => '2026-07-20 23:00:20',
                'updated_at'    => '2026-07-20 23:00:20',
            ],
            [
                'user_id'       => null,
                'name'          => 'Jorge',
                'lastname'      => 'Macias Mata',
                'birthday'      => '2019-08-29',
                'gender'        => 'male',
                'photo_path'    => null,
                'grade_average' => 0.0,
                'created_at'    => '2026-07-20 23:01:36',
                'updated_at'    => '2026-07-20 23:01:36',
            ],
        ];

        Student::insert($students);
    }
}
