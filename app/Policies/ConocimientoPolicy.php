<?php

namespace App\Policies;

use App\Models\Conocimiento;
use App\Models\User;

/**
 * Solo el autor de una ficha (o un administrador) puede editarla o eliminarla.
 * Laravel encuentra esta política automáticamente por su nombre.
 */
class ConocimientoPolicy
{
    /**
     * El administrador puede hacerlo todo. Si devuelve null, se revisan los demás métodos.
     */
    public function before(User $user, string $ability): ?bool
    {
        return $user->is_admin ? true : null;
    }

    public function update(User $user, Conocimiento $conocimiento): bool
    {
        return $user->id === $conocimiento->user_id;
    }

    public function delete(User $user, Conocimiento $conocimiento): bool
    {
        return $user->id === $conocimiento->user_id;
    }
}
