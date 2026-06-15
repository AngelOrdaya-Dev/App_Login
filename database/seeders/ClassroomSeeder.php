<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Classroom;

class ClassroomSeeder extends Seeder
{
    public function run(): void
    {
        $classrooms = [
            ['name' => 'Aula Magna A-101', 'capacity' => 60, 'is_active' => true],
            ['name' => 'Aula Magna A-102', 'capacity' => 60, 'is_active' => true],
            ['name' => 'Laboratorio B-201', 'capacity' => 30, 'is_active' => true],
            ['name' => 'Laboratorio B-202', 'capacity' => 30, 'is_active' => true],
            ['name' => 'Sala de Cómputo C-301', 'capacity' => 40, 'is_active' => true],
            ['name' => 'Sala de Cómputo C-302', 'capacity' => 40, 'is_active' => true],
            ['name' => 'Aula Taller D-101', 'capacity' => 25, 'is_active' => true],
            ['name' => 'Aula de Prácticas E-201', 'capacity' => 35, 'is_active' => true],
            ['name' => 'Auditorio Principal', 'capacity' => 150, 'is_active' => true],
            ['name' => 'Sala de Conferencias', 'capacity' => 50, 'is_active' => true],
        ];

        foreach ($classrooms as $classroom) {
            Classroom::firstOrCreate(['name' => $classroom['name']], $classroom);
        }
    }
}
