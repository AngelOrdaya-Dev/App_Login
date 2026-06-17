<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\User;
use Illuminate\Support\Facades\Hash;

class AdminUserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     * Único admin: angel1120171@hotmail.com
     */
    public function run(): void
    {
        // Eliminar la cuenta admin genérica si existe
        User::where('email', 'admin@admin.com')->delete();

        // Revocar rol de admin a xdangel755@gmail.com si existe
        User::where('email', 'xdangel755@gmail.com')->update(['role' => 'student']);

        // Único administrador del sistema
        User::updateOrCreate(
            ['email' => 'angel1120171@hotmail.com'],
            [
                'name'           => 'Angel Ordaya',
                'password'       => Hash::make('Admin2024#'),
                'role'           => 'admin',
                'terms_accepted' => true,
            ]
        );
    }
}
