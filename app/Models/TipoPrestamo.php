<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class TipoPrestamo extends Model
{
    use HasFactory;

    /** @var array<int, string> */
    protected $fillable = ['nombre', 'interes', 'plazo', 'descripcion'];

    protected $table = 'tipos_prestamo';

    /** @return HasMany<Prestamo> */
    public function prestamos(): HasMany
    {
        return $this->hasMany(Prestamo::class);
    }
}
