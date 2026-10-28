<?php

namespace App\Http\Requests\Admin;

use App\Http\Requests\ConocimientoRequest as BaseRequest;

/**
 * Mismas reglas de la ficha, más el autor que elige el administrador.
 */
class ConocimientoRequest extends BaseRequest
{
    public function rules()
    {
        return parent::rules() + [
            'user_id' => ['required', 'exists:users,id'],
        ];
    }

    public function attributes()
    {
        return parent::attributes() + [
            'user_id' => 'autor',
        ];
    }
}
