<?php

namespace Database\Factories;

use App\Models\TipoPrestamo;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends Factory<TipoPrestamo>
 */
class TipoPrestamoFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'nombre' => $this->faker->word(),
            'interes' => $this->faker->numberBetween(1, 15),
            'plazo' => $this->faker->randomElement([6, 12, 24, 36]),
            'descripcion' => $this->faker->sentence(),
        ];
    }
}
