<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

return new class extends Migration
{
    /**
     * Corrige los usuarios admin y docentes en producción:
     * - Único admin: angel1120171@hotmail.com
     * - 4 docentes con contraseñas individuales
     */
    public function up(): void
    {
        // ─── 1. Revocar admins no autorizados ───────────────────────────
        DB::table('users')
            ->where('role', 'admin')
            ->where('email', '!=', 'angel1120171@hotmail.com')
            ->update(['role' => 'student']);

        // Eliminar admin genérico
        DB::table('users')->where('email', 'admin@admin.com')->delete();

        // ─── 2. Asegurar que el único admin exista ───────────────────────
        $admin = DB::table('users')->where('email', 'angel1120171@hotmail.com')->first();
        if ($admin) {
            DB::table('users')
                ->where('email', 'angel1120171@hotmail.com')
                ->update([
                    'role'           => 'admin',
                    'name'           => 'Angel Ordaya',
                    'terms_accepted' => true,
                ]);
        } else {
            DB::table('users')->insert([
                'name'           => 'Angel Ordaya',
                'email'          => 'angel1120171@hotmail.com',
                'password'       => Hash::make('Admin2024#'),
                'role'           => 'admin',
                'terms_accepted' => true,
                'created_at'     => now(),
                'updated_at'     => now(),
            ]);
        }

        // ─── 3. Actualizar contraseñas de docentes ───────────────────────
        $teacherPasswords = [
            'giancarlos.barboza@premier.edu' => 'Barboza2024#',
            'elena.vasquez@premier.edu'      => 'Vasquez2024#',
            'roberto.sanchez@premier.edu'    => 'Sanchez2024#',
            'maria.fernandez@premier.edu'    => 'Fernandez2024#',
        ];

        foreach ($teacherPasswords as $email => $password) {
            DB::table('users')
                ->where('email', $email)
                ->where('role', 'teacher')
                ->update([
                    'password'   => Hash::make($password),
                    'updated_at' => now(),
                ]);
        }

        // Eliminar Carlos Mendoza si existe
        DB::table('users')->where('email', 'carlos.mendoza@premier.edu')->delete();
    }

    public function down(): void
    {
        // No revertir cambios de seguridad
    }
};
