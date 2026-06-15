<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\AuditLog;
use App\Models\User;

class AuditLogSeeder extends Seeder
{
    public function run(): void
    {
        $admin = User::where('role', 'admin')->first();

        if ($admin) {
            $logs = [
                ['action' => 'Inicio de Sesión', 'details' => 'El usuario administrador inició sesión exitosamente.', 'user_id' => $admin->id, 'ip_address' => '192.168.1.10', 'created_at' => now()->subDays(2)],
                ['action' => 'Actualización de Sistema', 'details' => 'Se aplicó el parche de seguridad v2.1.0.', 'user_id' => $admin->id, 'ip_address' => '192.168.1.10', 'created_at' => now()->subDays(1)],
                ['action' => 'Registro de Docente', 'details' => 'Se registró al docente Giancarlos Barboza.', 'user_id' => $admin->id, 'ip_address' => '192.168.1.10', 'created_at' => now()->subHours(12)],
                ['action' => 'Asignación de Horario', 'details' => 'Se asignó horario para Desarrollo Web Fullstack.', 'user_id' => $admin->id, 'ip_address' => '192.168.1.10', 'created_at' => now()->subHours(5)],
                ['action' => 'Inicio de Sesión', 'details' => 'El usuario administrador inició sesión exitosamente.', 'user_id' => $admin->id, 'ip_address' => '192.168.1.10', 'created_at' => now()],
            ];

            foreach ($logs as $log) {
                AuditLog::create($log);
            }
        }
    }
}
