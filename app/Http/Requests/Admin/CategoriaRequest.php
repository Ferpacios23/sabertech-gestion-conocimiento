<?php

namespace App\Http\Requests\Admin;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class CategoriaRequest extends FormRequest
{
    /**
     * Colores disponibles (los mismos que entiende x-categoria-badge).
     */
    public const COLORES = [
        'red' => 'Rojo',
        'green' => 'Verde',
        'blue' => 'Azul',
        'purple' => 'Morado',
        'amber' => 'Ámbar',
        'slate' => 'Gris',
    ];

    public function authorize()
    {
        return true; // el middleware admin ya protege la ruta
    }

    public function rules()
    {
        return [
            'nombre' => ['required', 'string', 'max:60', Rule::unique('categorias', 'nombre')->ignore($this->route('categoria'))],
            'descripcion' => ['nullable', 'string', 'max:255'],
            'color' => ['required', Rule::in(array_keys(self::COLORES))],
        ];
    }

    public function attributes()
    {
        return [
            'nombre' => 'nombre',
            'descripcion' => 'descripción',
            'color' => 'color',
        ];
    }

    public function messages()
    {
        return [
            'nombre.unique' => 'Ya existe una categoría con ese nombre.',
            'color.in' => 'Elige uno de los colores de la lista.',
        ];
    }
}
