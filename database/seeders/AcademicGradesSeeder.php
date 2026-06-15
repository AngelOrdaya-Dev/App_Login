<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class AcademicGradesSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $career = \App\Models\Career::first();
        if (!$career) return;

        $courses = [
            ['name' => 'Algoritmos y Estructura de Datos', 'credits' => 5],
            ['name' => 'Base de Datos I', 'credits' => 4],
            ['name' => 'Desarrollo Web Fullstack', 'credits' => 6],
            ['name' => 'Matemática Discreta', 'credits' => 4],
        ];

        foreach ($courses as $c) {
            $course = \App\Models\Course::firstOrCreate(
                ['name' => $c['name'], 'career_id' => $career->id],
                ['credits' => $c['credits']]
            );

            // Asignar nota al admin (como estudiante de prueba)
            $admin = \App\Models\User::where('email', 'admin@admin.com')->first();
            if ($admin) {
                if (!\App\Models\Grade::where('user_id', $admin->id)->where('course_id', $course->id)->exists()) {
                    $gradeVal = rand(10, 20);
                    \App\Models\Grade::create([
                        'user_id' => $admin->id,
                        'course_id' => $course->id,
                        'grade' => $gradeVal,
                        'status' => $gradeVal >= 11 ? 'pass' : 'fail'
                    ]);
                }
            }
        }
    }
}
