<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    /**
     * Trabajadores de ejemplo de la empresa simulada. Contraseña de todos: password
     */
    public function run()
    {
        $usuarios = [
            ['name' => 'Ferly Palacios', 'email' => 'ferly@techsolutions.test', 'area' => 'Gerencia'],
            ['name' => 'Frank Hinestroza', 'email' => 'frank@techsolutions.test', 'area' => 'Soporte'],
            ['name' => 'Andrés Rentería', 'email' => 'andres@techsolutions.test', 'area' => 'Infraestructura y DevOps'],
            ['name' => 'Luisa Córdoba', 'email' => 'luisa@techsolutions.test', 'area' => 'Proyectos'],
            ['name' => 'Camila Asprilla', 'email' => 'camila@techsolutions.test', 'area' => 'Comercial'],
        ];

        foreach ($usuarios as $usuario) {
            User::updateOrCreate(
                ['email' => $usuario['email']],
                $usuario + ['password' => Hash::make('password'), 'email_verified_at' => now()]
            );
        }

        // is_admin no es asignable en masa: se marca aparte
        User::where('email', 'ferly@techsolutions.test')->update(['is_admin' => true]);
    }
}
