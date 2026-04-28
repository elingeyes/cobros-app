<?php

namespace Database\Factories;

use App\Models\Cuota;
use App\Models\Pago;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends Factory<Pago>
 */
class PagoFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'cuota_id' => Cuota::factory(),
            'fecha' => now()->toDateString(),
            'monto' => $this->faker->numberBetween(100, 1000),
            'metodo' => $this->faker->randomElement(['efectivo', 'cheque', 'transferencia', 'tarjeta']),
        ];
    }
}
