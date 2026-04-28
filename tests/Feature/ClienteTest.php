<?php

namespace Tests\Feature;

use App\Models\Cliente;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class ClienteTest extends TestCase
{
    use RefreshDatabase;

    public function test_crear_cliente(): void
    {
        $datos = [
            'nombre' => 'Juan',
            'apellido' => 'Pérez',
            'ci' => '12345678',
            'email' => 'juan@example.com',
            'telefono' => '555-1234',
            'direccion' => 'Calle Principal 123',
        ];

        $response = $this->postJson('/clientes', $datos);

        $response->assertStatus(201);
        $response->assertJsonStructure(['id', 'nombre', 'apellido', 'ci', 'email']);
        $this->assertDatabaseHas('clientes', ['ci' => '12345678']);
    }

    public function test_listar_clientes(): void
    {
        Cliente::factory()->count(3)->create();

        $response = $this->getJson('/clientes');

        $response->assertStatus(200);
        $response->assertJsonCount(3);
    }

    public function test_mostrar_cliente(): void
    {
        $cliente = Cliente::factory()->create();

        $response = $this->getJson("/clientes/{$cliente->id}");

        $response->assertStatus(200);
        $response->assertJsonFragment(['id' => $cliente->id, 'nombre' => $cliente->nombre]);
    }

    public function test_actualizar_cliente(): void
    {
        $cliente = Cliente::factory()->create();

        $response = $this->patchJson("/clientes/{$cliente->id}", [
            'nombre' => 'Carlos',
        ]);

        $response->assertStatus(200);
        $this->assertDatabaseHas('clientes', ['id' => $cliente->id, 'nombre' => 'Carlos']);
    }

    public function test_eliminar_cliente(): void
    {
        $cliente = Cliente::factory()->create();

        $response = $this->deleteJson("/clientes/{$cliente->id}");

        $response->assertStatus(200);
        $this->assertDatabaseMissing('clientes', ['id' => $cliente->id]);
    }

    public function test_validar_email_unico(): void
    {
        Cliente::factory()->create(['email' => 'juan@example.com']);

        $response = $this->postJson('/clientes', [
            'nombre' => 'Juan',
            'apellido' => 'Pérez',
            'ci' => '87654321',
            'email' => 'juan@example.com',
        ]);

        $response->assertStatus(422);
        $response->assertJsonValidationErrors('email');
    }

    public function test_validar_ci_unico(): void
    {
        Cliente::factory()->create(['ci' => '12345678']);

        $response = $this->postJson('/clientes', [
            'nombre' => 'Juan',
            'apellido' => 'Pérez',
            'ci' => '12345678',
            'email' => 'juan@example.com',
        ]);

        $response->assertStatus(422);
        $response->assertJsonValidationErrors('ci');
    }
}
