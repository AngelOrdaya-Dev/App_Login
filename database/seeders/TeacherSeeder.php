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
            [
                'name'     => 'Giancarlos Barboza',
                'email'    => 'giancarlos.barboza@premier.edu',
                'password' => 'Barboza2024#',
            ],
            [
                'name'     => 'Elena Vásquez',
                'email'    => 'elena.vasquez@premier.edu',
                'password' => 'Vasquez2024#',
            ],
            [
                'name'     => 'Roberto Sánchez',
                'email'    => 'roberto.sanchez@premier.edu',
                'password' => 'Sanchez2024#',
            ],
            [
                'name'     => 'María Fernández',
                'email'    => 'maria.fernandez@premier.edu',
                'password' => 'Fernandez2024#',
            ],
        ];

        foreach ($teachers as $teacher) {
            User::updateOrCreate(
                ['email' => $teacher['email']],
                [
                    'name'           => $teacher['name'],
                    'password'       => Hash::make($teacher['password']),
                    'role'           => 'teacher',
                    'terms_accepted' => true,
                ]
            );
        }

        // Eliminar el 5to docente si existía (Carlos Mendoza no fue pedido)
        User::where('email', 'carlos.mendoza@premier.edu')->delete();
    }
}
