<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Cuota extends Model
{
    use HasFactory;

    /** @var array<int, string> */
    protected $fillable = ['prestamo_id', 'numero', 'vencimiento', 'monto', 'saldo', 'estado'];

    /** @var array<int, string> */
    protected $casts = [
        'vencimiento' => 'date',
        'monto' => 'decimal:2',
        'saldo' => 'decimal:2',
    ];

    /** @return BelongsTo<Prestamo> */
    public function prestamo(): BelongsTo
    {
        return $this->belongsTo(Prestamo::class);
    }

    /** @return HasMany<Pago> */
    public function pagos(): HasMany
    {
        return $this->hasMany(Pago::class);
    }
}
