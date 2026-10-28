<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * php artisan migrate --seed
     */
    public function run()
    {
        $this->call([
            CategoriaSeeder::class,
            UserSeeder::class,
            ConocimientoSeeder::class,
            EquipoSeeder::class,
        ]);
    }
}
