<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Pago extends Model
{
    use HasFactory;

    /** @var array<int, string> */
    protected $fillable = ['cuota_id', 'fecha', 'monto', 'metodo'];

    /** @var array<int, string> */
    protected $casts = [
        'fecha' => 'date',
        'monto' => 'decimal:2',
    ];

    /** @return BelongsTo<Cuota> */
    public function cuota(): BelongsTo
    {
        return $this->belongsTo(Cuota::class);
    }
}
