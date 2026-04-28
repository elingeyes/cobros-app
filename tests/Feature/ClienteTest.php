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

        $response = $this->post('/clientes', $datos);

        $response->assertRedirect(route('clientes.index'));
        $this->assertDatabaseHas('clientes', ['ci' => '12345678']);
    }

    public function test_listar_clientes(): void
    {
        Cliente::factory()->count(3)->create();

        $response = $this->get('/clientes');

        $response->assertStatus(200);
        $response->assertViewIs('clientes.index');
        $response->assertViewHas('clientes');
    }

    public function test_mostrar_cliente(): void
    {
        $cliente = Cliente::factory()->create();

        $response = $this->get("/clientes/{$cliente->id}");

        $response->assertStatus(200);
        $response->assertViewIs('clientes.show');
        $response->assertViewHas('cliente', $cliente);
    }


    public function test_actualizar_cliente(): void
    {
        $cliente = Cliente::factory()->create();

        $response = $this->put("/clientes/{$cliente->id}", [
            'nombre' => 'Carlos',
            'apellido' => $cliente->apellido,
            'ci' => $cliente->ci,
            'email' => $cliente->email,
        ]);

        $response->assertRedirect(route('clientes.show', $cliente));
        $this->assertDatabaseHas('clientes', ['id' => $cliente->id, 'nombre' => 'Carlos']);
    }

    public function test_eliminar_cliente(): void
    {
        $cliente = Cliente::factory()->create();

        $response = $this->delete("/clientes/{$cliente->id}");

        $response->assertRedirect(route('clientes.index'));
        $this->assertDatabaseMissing('clientes', ['id' => $cliente->id]);
    }

    public function test_validar_email_unico(): void
    {
        Cliente::factory()->create(['email' => 'juan@example.com']);

        $response = $this->post('/clientes', [
            'nombre' => 'Juan',
            'apellido' => 'Pérez',
            'ci' => '87654321',
            'email' => 'juan@example.com',
        ]);

        $response->assertSessionHasErrors('email');
    }

    public function test_validar_ci_unico(): void
    {
        Cliente::factory()->create(['ci' => '12345678']);

        $response = $this->post('/clientes', [
            'nombre' => 'Juan',
            'apellido' => 'Pérez',
            'ci' => '12345678',
            'email' => 'juan@example.com',
        ]);

        $response->assertSessionHasErrors('ci');
    }
}
