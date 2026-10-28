<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class Conocimiento extends Model
{
    protected $fillable = ['titulo', 'problema', 'solucion', 'enlace', 'categoria_id'];

    public function categoria(): BelongsTo
    {
        return $this->belongsTo(Categoria::class);
    }

    public function autor(): BelongsTo
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    public function etiquetas(): BelongsToMany
    {
        return $this->belongsToMany(Etiqueta::class)->orderBy('nombre');
    }

    /**
     * Búsqueda por palabra clave en el título, el problema, la solución y las etiquetas.
     */
    public function scopeBuscar(Builder $query, ?string $texto): Builder
    {
        $texto = trim((string) $texto);

        if ($texto === '') {
            return $query;
        }

        return $query->where(function (Builder $q) use ($texto) {
            $q->where('titulo', 'like', "%{$texto}%")
                ->orWhere('problema', 'like', "%{$texto}%")
                ->orWhere('solucion', 'like', "%{$texto}%")
                ->orWhereHas('etiquetas', fn (Builder $e) => $e->where('nombre', 'like', "%{$texto}%"));
        });
    }

    public function scopeDeCategoria(Builder $query, $categoriaId): Builder
    {
        return $categoriaId ? $query->where('categoria_id', $categoriaId) : $query;
    }

    public function scopeConEtiqueta(Builder $query, ?string $etiqueta): Builder
    {
        return $etiqueta
            ? $query->whereHas('etiquetas', fn (Builder $e) => $e->where('nombre', $etiqueta))
            : $query;
    }
}
