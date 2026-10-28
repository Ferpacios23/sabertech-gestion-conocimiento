<?php

namespace App\Http\Requests\Admin;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class UserRequest extends FormRequest
{
    public function authorize()
    {
        return true; // el middleware admin ya protege la ruta
    }

    public function rules()
    {
        return [
            'name' => ['required', 'string', 'max:255'],
            'area' => ['required', Rule::in(config('sabertech.areas'))],
            'is_admin' => ['nullable', 'boolean'],
        ];
    }

    public function attributes()
    {
        return [
            'name' => 'nombre',
            'area' => 'área',
            'is_admin' => 'administrador',
        ];
    }

    public function messages()
    {
        return [
            'area.in' => 'Elige un área de la lista.',
        ];
    }
}
