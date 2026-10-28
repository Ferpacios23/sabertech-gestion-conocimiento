<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Support\Collection;
use Illuminate\Support\Str;

class Etiqueta extends Model
{
    protected $fillable = ['nombre'];

    public function conocimientos(): BelongsToMany
    {
        return $this->belongsToMany(Conocimiento::class);
    }

    /**
     * Convierte un texto como "Laravel, despliegue, permisos" en los ids de sus etiquetas.
     * Las que no existen se crean.
     */
    public static function idsDesdeTexto(?string $texto): Collection
    {
        return collect(explode(',', (string) $texto))
            ->map(fn ($nombre) => Str::of($nombre)->trim()->lower()->replace('#', '')->replace(' ', '-')->limit(40, '')->value())
            ->filter()
            ->unique()
            ->map(fn ($nombre) => static::firstOrCreate(['nombre' => $nombre])->id)
            ->values();
    }
}
