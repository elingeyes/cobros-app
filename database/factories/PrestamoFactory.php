<?php

namespace Database\Factories;

use App\Models\Cliente;
use App\Models\Prestamo;
use App\Models\TipoPrestamo;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends Factory<Prestamo>
 */
class PrestamoFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'cliente_id' => Cliente::factory(),
            'tipo_prestamo_id' => TipoPrestamo::factory(),
            'monto' => $this->faker->numberBetween(5000, 100000),
            'fecha' => now()->subMonths(6)->toDateString(),
            'estado' => 'activo',
        ];
    }
}
