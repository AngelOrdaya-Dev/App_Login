<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;
use App\Models\Course;
use App\Models\Career;
use App\Models\Classroom;
use App\Models\Schedule;

class ScheduleSeeder extends Seeder
{
    public function run(): void
    {
        $teacher = User::where('name', 'Giancarlos Barboza')->first();
        $career = Career::firstOrCreate(['name' => 'Ingeniería de Software']);
        
        $course = Course::firstOrCreate(
            ['code' => 'CUR-003'],
            [
                'name' => 'Desarrollo Web Fullstack',
                'career_id' => $career->id,
                'teacher_id' => $teacher ? $teacher->id : null,
                'credits' => 6
            ]
        );

        $classroom = Classroom::firstOrCreate(
            ['name' => 'Laboratorio B-201'],
            ['capacity' => 30, 'is_active' => true]
        );

        $days = [1, 3, 4]; // Lunes, Miércoles, Jueves

        foreach ($days as $day) {
            Schedule::firstOrCreate(
                [
                    'course_id' => $course->id,
                    'day_of_week' => $day,
                ],
                [
                    'classroom_id' => $classroom->id,
                    'start_time' => '13:30:00',
                    'end_time' => '17:30:00',
                ]
            );
        }
    }
}
