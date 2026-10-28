<?php

namespace Database\Seeders;

use App\Models\Categoria;
use Illuminate\Database\Seeder;

class CategoriaSeeder extends Seeder
{
    public function run()
    {
        $categorias = [
            ['nombre' => 'Incidencia', 'color' => 'red', 'descripcion' => 'Fallas reportadas por clientes o encontradas en producción y cómo se resolvieron.'],
            ['nombre' => 'Despliegue', 'color' => 'green', 'descripcion' => 'Pasos para publicar o actualizar aplicaciones en servidores.'],
            ['nombre' => 'Desarrollo', 'color' => 'blue', 'descripcion' => 'Decisiones de arquitectura, código reutilizable y soluciones técnicas.'],
            ['nombre' => 'Procedimiento', 'color' => 'purple', 'descripcion' => 'Cómo se hace una tarea de la empresa, paso a paso.'],
            ['nombre' => 'Buena práctica', 'color' => 'amber', 'descripcion' => 'Lecciones aprendidas y recomendaciones del equipo.'],
        ];

        foreach ($categorias as $categoria) {
            Categoria::updateOrCreate(['nombre' => $categoria['nombre']], $categoria);
        }
    }
}
