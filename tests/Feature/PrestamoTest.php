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

        $response = $this->post('/prestamos', $datos);

        $this->assertDatabaseHas('prestamos', ['monto' => 10000]);
        $prestamo = Prestamo::where('monto', 10000)->first();
        $this->assertEquals(12, Cuota::where('prestamo_id', $prestamo->id)->count());
    }

    public function test_calcular_monto_cuota_correctamente(): void
    {
        $cliente = Cliente::factory()->create();
        $tipoPrestamo = TipoPrestamo::factory()->create([
            'interes' => 5,
            'plazo' => 12,
        ]);

        $this->post('/prestamos', [
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

        $response = $this->get('/prestamos');

        $response->assertStatus(200);
        $response->assertViewIs('prestamos.index');
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

        $response = $this->get("/prestamos/{$prestamo->id}");

        $response->assertStatus(200);
        $response->assertViewIs('prestamos.show');
    }

    public function test_actualizar_estado_prestamo(): void
    {
        $prestamo = Prestamo::factory()->create();

        $response = $this->put("/prestamos/{$prestamo->id}", [
            'estado' => 'cancelado',
        ]);

        $response->assertRedirect();
        $this->assertDatabaseHas('prestamos', ['id' => $prestamo->id, 'estado' => 'cancelado']);
    }

    public function test_validar_campos_requeridos(): void
    {
        $response = $this->post('/prestamos', []);

        $response->assertSessionHasErrors(['cliente_id', 'tipo_prestamo_id', 'monto', 'fecha']);
    }
}
