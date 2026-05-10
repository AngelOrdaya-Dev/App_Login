<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class AcademicDataSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $admin = \App\Models\User::where('email', 'admin@admin.com')->first();
        $career = \App\Models\Career::first() ?? \App\Models\Career::create(['name' => 'Ingeniería de Sistemas']);

        if ($admin) {
            // Pagos de ejemplo
            \App\Models\Payment::create([
                'user_id' => $admin->id,
                'amount' => 150.00,
                'description' => 'Matrícula Ciclo 2026-I',
                'status' => 'paid',
                'payment_date' => now(),
            ]);

            \App\Models\Payment::create([
                'user_id' => $admin->id,
                'amount' => 25.00,
                'description' => 'Derecho de Carnet Universitario',
                'status' => 'pending',
            ]);

            // Inscripciones de ejemplo
            \App\Models\Enrollment::create([
                'user_id' => $admin->id,
                'career_id' => $career->id,
                'type' => 'regular',
                'status' => 'approved',
            ]);

            \App\Models\Enrollment::create([
                'user_id' => $admin->id,
                'career_id' => $career->id,
                'type' => 'reingreso',
                'status' => 'pending',
            ]);
        }
    }
}
