<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use App\Models\User;
use App\Models\Career;
use App\Models\Course;
use App\Models\Grade;

class StudentGradeSeeder extends Seeder
{
    public function run(): void
    {
        // 9 students — one per career (careers must exist from CareerSeeder)
        $students = [
            ['name' => 'Carlos Quispe Mamani',    'email' => 'carlos.quispe@premier.edu',    'career' => 'Ingeniería de Software'],
            ['name' => 'Lucía Torres Medina',     'email' => 'lucia.torres@premier.edu',     'career' => 'Diseño Gráfico'],
            ['name' => 'Diego Vargas Huanca',     'email' => 'diego.vargas@premier.edu',     'career' => 'Administración de Empresas'],
            ['name' => 'Sofía Flores Ramos',      'email' => 'sofia.flores@premier.edu',     'career' => 'Medicina'],
            ['name' => 'Andrés Soto Paredes',     'email' => 'andres.soto@premier.edu',      'career' => 'Psicología'],
            ['name' => 'Valeria Cruz Atahuallpa', 'email' => 'valeria.cruz@premier.edu',     'career' => 'Arquitectura'],
            ['name' => 'Miguel Ángel León Ruiz',  'email' => 'miguel.leon@premier.edu',      'career' => 'Contabilidad'],
            ['name' => 'Gabriela Morales Díaz',   'email' => 'gabriela.morales@premier.edu', 'career' => 'Derecho'],
            ['name' => 'Sebastián Cárdenas Nieto','email' => 'sebastian.cardenas@premier.edu','career' => 'Marketing Digital'],
        ];

        // Grades to assign to each student (will pick the first available course for their career)
        $gradeValues = [17, 14, 11, 18, 15, 13, 16, 12, 19];

        foreach ($students as $index => $data) {
            $career = Career::where('name', $data['career'])->first();
            if (!$career) continue;

            $user = User::firstOrCreate(
                ['email' => $data['email']],
                [
                    'name'           => $data['name'],
                    'password'       => Hash::make('alumno123'),
                    'role'           => 'student',
                    'career_id'      => $career->id,
                    'terms_accepted' => true,
                ]
            );

            // Assign a grade: use first course of the career, or the shared Desarrollo Web Fullstack course
            $course = Course::where('career_id', $career->id)->first()
                   ?? Course::first();

            if ($course && !Grade::where('user_id', $user->id)->where('course_id', $course->id)->exists()) {
                $gradeVal = $gradeValues[$index];
                Grade::create([
                    'user_id'   => $user->id,
                    'course_id' => $course->id,
                    'grade'     => $gradeVal,
                    'status'    => $gradeVal >= 11 ? 'pass' : 'fail',
                ]);
            }
        }
    }
}
