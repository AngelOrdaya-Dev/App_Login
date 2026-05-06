<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Career;

class CareerSeeder extends Seeder
{
    public function run(): void
    {
        $careers = [
            'Ingeniería de Software',
            'Diseño Gráfico',
            'Administración de Empresas',
            'Medicina',
            'Psicología',
            'Arquitectura',
            'Contabilidad',
            'Derecho',
            'Marketing Digital',
            'Ingeniería Industrial',
        ];

        foreach ($careers as $career) {
            Career::create(['name' => $career]);
        }
    }
}
