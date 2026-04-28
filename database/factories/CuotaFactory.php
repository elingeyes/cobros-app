<?php

namespace Database\Factories;

use App\Models\Cuota;
use App\Models\Prestamo;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends Factory<Cuota>
 */
class CuotaFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'prestamo_id' => Prestamo::factory(),
            'numero' => $this->faker->numberBetween(1, 12),
            'vencimiento' => now()->addMonths(2)->toDateString(),
            'monto' => $this->faker->numberBetween(100, 2000),
            'saldo' => $this->faker->numberBetween(0, 2000),
            'estado' => $this->faker->randomElement(['pendiente', 'parcial', 'pagada']),
        ];
    }
}
