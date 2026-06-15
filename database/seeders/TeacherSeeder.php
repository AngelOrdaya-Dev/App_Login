<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;
use Illuminate\Support\Facades\Hash;

class TeacherSeeder extends Seeder
{
    public function run(): void
    {
        $teachers = [
            ['name' => 'Giancarlos Barboza', 'email' => 'giancarlos.barboza@premier.edu'],
            ['name' => 'Elena Vásquez', 'email' => 'elena.vasquez@premier.edu'],
            ['name' => 'Roberto Sánchez', 'email' => 'roberto.sanchez@premier.edu'],
            ['name' => 'María Fernández', 'email' => 'maria.fernandez@premier.edu'],
            ['name' => 'Carlos Mendoza', 'email' => 'carlos.mendoza@premier.edu'],
        ];

        foreach ($teachers as $teacher) {
            User::firstOrCreate(
                ['email' => $teacher['email']],
                [
                    'name' => $teacher['name'],
                    'password' => Hash::make('docente123'),
                    'role' => 'teacher',
                    'terms_accepted' => true,
                ]
            );
        }
    }
}
