<?php

namespace Tests\Feature;

use App\Models\Cuota;
use App\Models\Pago;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class PagoTest extends TestCase
{
    use RefreshDatabase;

    public function test_crear_pago_actualiza_cuota(): void
    {
        $cuota = Cuota::factory()->create([
            'monto' => 1000,
            'saldo' => 1000,
            'estado' => 'pendiente',
        ]);

        $datos = [
            'cuota_id' => $cuota->id,
            'fecha' => now()->toDateString(),
            'monto' => 500,
            'metodo' => 'efectivo',
        ];

        $response = $this->postJson('/pagos', $datos);

        $response->assertStatus(201);
        $cuota->refresh();
        $this->assertEquals(500, $cuota->saldo);
        $this->assertEquals('parcial', $cuota->estado);
    }

    public function test_pago_completo_marca_cuota_como_pagada(): void
    {
        $cuota = Cuota::factory()->create([
            'monto' => 1000,
            'saldo' => 1000,
            'estado' => 'pendiente',
        ]);

        $this->postJson('/pagos', [
            'cuota_id' => $cuota->id,
            'fecha' => now()->toDateString(),
            'monto' => 1000,
            'metodo' => 'transferencia',
        ]);

        $cuota->refresh();
        $this->assertEquals(0, $cuota->saldo);
        $this->assertEquals('pagada', $cuota->estado);
    }

    public function test_listar_pagos(): void
    {
        $cuota = Cuota::factory()->create();
        Pago::factory()->count(3)->create(['cuota_id' => $cuota->id]);

        $response = $this->getJson('/pagos');

        $response->assertStatus(200);
        $response->assertJsonCount(3);
    }

    public function test_mostrar_pago(): void
    {
        $pago = Pago::factory()->create();

        $response = $this->getJson("/pagos/{$pago->id}");

        $response->assertStatus(200);
        $response->assertJsonFragment(['id' => $pago->id, 'monto' => (string) $pago->monto]);
    }

    public function test_eliminar_pago(): void
    {
        $pago = Pago::factory()->create();

        $response = $this->deleteJson("/pagos/{$pago->id}");

        $response->assertStatus(200);
        $this->assertDatabaseMissing('pagos', ['id' => $pago->id]);
    }

    public function test_validar_metodo_pago(): void
    {
        $cuota = Cuota::factory()->create();

        $response = $this->postJson('/pagos', [
            'cuota_id' => $cuota->id,
            'fecha' => now()->toDateString(),
            'monto' => 500,
            'metodo' => 'invalido',
        ]);

        $response->assertStatus(422);
        $response->assertJsonValidationErrors('metodo');
    }

    public function test_pago_parcial_multiple(): void
    {
        $cuota = Cuota::factory()->create([
            'monto' => 1000,
            'saldo' => 1000,
            'estado' => 'pendiente',
        ]);

        $this->postJson('/pagos', [
            'cuota_id' => $cuota->id,
            'fecha' => now()->toDateString(),
            'monto' => 300,
            'metodo' => 'efectivo',
        ]);

        $cuota->refresh();
        $this->assertEquals(700, $cuota->saldo);
        $this->assertEquals('parcial', $cuota->estado);

        $this->postJson('/pagos', [
            'cuota_id' => $cuota->id,
            'fecha' => now()->toDateString(),
            'monto' => 700,
            'metodo' => 'cheque',
        ]);

        $cuota->refresh();
        $this->assertEquals(0, $cuota->saldo);
        $this->assertEquals('pagada', $cuota->estado);
    }
}
