<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class ConocimientoRequest extends FormRequest
{
    public function authorize()
    {
        return true; // los permisos de edición se revisan en ConocimientoPolicy
    }

    public function rules()
    {
        return [
            'titulo' => ['required', 'string', 'max:150'],
            'categoria_id' => ['required', 'exists:categorias,id'],
            'problema' => ['required', 'string', 'max:5000'],
            'solucion' => ['required', 'string', 'max:10000'],
            'enlace' => ['nullable', 'url', 'max:255'],
            'etiquetas' => ['nullable', 'string', 'max:255'],
        ];
    }

    public function attributes()
    {
        return [
            'titulo' => 'título',
            'categoria_id' => 'categoría',
            'problema' => 'problema o contexto',
            'solucion' => 'solución',
            'enlace' => 'enlace de referencia',
            'etiquetas' => 'etiquetas',
        ];
    }
}
