<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        User::create([
            'name'      => 'Admin',
            'lastname' => 'DUAL NET',
            'username'  => 'admin.dn',
            'email'     => 'adminDN@campus.com',
            'password'  => Hash::make('admin1234'),
            'role_id'   => 1,
            'school_id' => 1,
            'active'    => true,
        ]);

        User::create([
            'name'      => 'Admin',
            'lastname' => 'General',
            'username'  => 'admin.global',
            'email'     => 'adming@campus.com',
            'password'  => Hash::make('adming123'),
            'role_id'   => 2,
            'school_id' => 1,
            'active'    => true,
        ]);

        User::create([
            'name'      => 'Carlos',
            'lastname' => 'Mendoza Silva',
            'username'  => 'carlos.mendoza',
            'email'     => 'carlos.mendoza@campus.com',
            'password'  => Hash::make('carlos123'),
            'role_id'   => 3,
            'school_id' => 1,
            'active'    => true,
        ]);
    }
}
