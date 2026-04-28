<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Prestamo extends Model
{
    use HasFactory;

    /** @var array<int, string> */
    protected $fillable = ['cliente_id', 'tipo_prestamo_id', 'monto', 'fecha', 'estado'];

    /** @var array<int, string> */
    protected $casts = [
        'fecha' => 'date',
        'monto' => 'decimal:2',
    ];

    /** @return BelongsTo<Cliente> */
    public function cliente(): BelongsTo
    {
        return $this->belongsTo(Cliente::class);
    }

    /** @return BelongsTo<TipoPrestamo> */
    public function tipoPrestamo(): BelongsTo
    {
        return $this->belongsTo(TipoPrestamo::class);
    }

    /** @return HasMany<Cuota> */
    public function cuotas(): HasMany
    {
        return $this->hasMany(Cuota::class);
    }
}
