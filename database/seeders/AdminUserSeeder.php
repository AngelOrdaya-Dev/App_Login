<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class AdminUserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Crear cuenta admin por defecto
        \App\Models\User::firstOrCreate(
            ['email' => 'admin@admin.com'],
            [
                'name' => 'Administrador Global',
                'password' => \Illuminate\Support\Facades\Hash::make('admin123'),
                'role' => 'admin',
                'terms_accepted' => true,
            ]
        );

        // Promover la cuenta del dueño de la app a admin (si ya existe por Social Login)
        $ownerEmail = env('APP_OWNER_EMAIL', 'xdangel755@gmail.com');
        \App\Models\User::where('email', $ownerEmail)->update(['role' => 'admin']);
    }
}
