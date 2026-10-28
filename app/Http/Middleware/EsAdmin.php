<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;

class EsAdmin
{
    /**
     * Solo deja pasar a los usuarios marcados como administradores.
     */
    public function handle(Request $request, Closure $next)
    {
        if (! $request->user()?->is_admin) {
            return redirect()->route('dashboard')
                ->with('status', 'La sección de administración es solo para administradores.');
        }

        return $next($request);
    }
}
