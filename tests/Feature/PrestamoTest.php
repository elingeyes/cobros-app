<?php

namespace Tests\Feature;

use App\Models\Cliente;
use App\Models\Cuota;
use App\Models\Prestamo;
use App\Models\TipoPrestamo;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class PrestamoTest extends TestCase
{
    use RefreshDatabase;

    public function test_crear_prestamo_genera_cuotas(): void
    {
        $cliente = Cliente::factory()->create();
        $tipoPrestamo = TipoPrestamo::factory()->create([
            'interes' => 5,
            'plazo' => 12,
        ]);

        $datos = [
            'cliente_id' => $cliente->id,
            'tipo_prestamo_id' => $tipoPrestamo->id,
            'monto' => 10000,
            'fecha' => now()->toDateString(),
        ];

        $response = $this->postJson('/prestamos', $datos);

        $response->assertStatus(201);
        $response->assertJsonStructure(['id', 'cliente_id', 'tipo_prestamo_id', 'monto', 'cuotas']);
        $this->assertDatabaseHas('prestamos', ['monto' => 10000]);
        $this->assertEquals(12, Cuota::where('prestamo_id', $response->json('id'))->count());
    }

    public function test_calcular_monto_cuota_correctamente(): void
    {
        $cliente = Cliente::factory()->create();
        $tipoPrestamo = TipoPrestamo::factory()->create([
            'interes' => 5,
            'plazo' => 12,
        ]);

        $this->postJson('/prestamos', [
            'cliente_id' => $cliente->id,
            'tipo_prestamo_id' => $tipoPrestamo->id,
            'monto' => 10000,
            'fecha' => now()->toDateString(),
        ]);

        $cuotas = Cuota::all();
        $montoCuota = $cuotas->first()->monto;
        $montoEsperado = round((10000 * 1.05) / 12, 2);

        $this->assertEquals($montoEsperado, $montoCuota);
    }

    public function test_listar_prestamos(): void
    {
        $cliente = Cliente::factory()->create();
        $tipoPrestamo = TipoPrestamo::factory()->create();

        Prestamo::factory()->count(2)->create([
            'cliente_id' => $cliente->id,
            'tipo_prestamo_id' => $tipoPrestamo->id,
        ]);

        $response = $this->getJson('/prestamos');

        $response->assertStatus(200);
        $response->assertJsonCount(2);
    }

    public function test_mostrar_prestamo_con_cuotas(): void
    {
        $cliente = Cliente::factory()->create();
        $tipoPrestamo = TipoPrestamo::factory()->create([
            'interes' => 5,
            'plazo' => 12,
        ]);

        $prestamo = Prestamo::factory()->create([
            'cliente_id' => $cliente->id,
            'tipo_prestamo_id' => $tipoPrestamo->id,
        ]);

        Cuota::factory()->count(12)->create(['prestamo_id' => $prestamo->id]);

        $response = $this->getJson("/prestamos/{$prestamo->id}");

        $response->assertStatus(200);
        $response->assertJsonStructure(['id', 'cuotas']);
    }

    public function test_actualizar_estado_prestamo(): void
    {
        $prestamo = Prestamo::factory()->create();

        $response = $this->patchJson("/prestamos/{$prestamo->id}", [
            'estado' => 'cancelado',
        ]);

        $response->assertStatus(200);
        $this->assertDatabaseHas('prestamos', ['id' => $prestamo->id, 'estado' => 'cancelado']);
    }

    public function test_validar_campos_requeridos(): void
    {
        $response = $this->postJson('/prestamos', []);

        $response->assertStatus(422);
        $response->assertJsonValidationErrors(['cliente_id', 'tipo_prestamo_id', 'monto', 'fecha']);
    }
}
