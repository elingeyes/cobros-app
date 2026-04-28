<?php

namespace Database\Seeders;

use App\Models\Cliente;
use App\Models\Pago;
use App\Models\Prestamo;
use App\Models\TipoPrestamo;
use App\Services\PrestamoService;
use Illuminate\Database\Seeder;

class LoanSystemSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $prestamoService = app(PrestamoService::class);

        // Crear tipos de préstamo
        $tipoPrestamo1 = TipoPrestamo::create([
            'nombre' => 'Préstamo Personal',
            'interes' => 5,
            'plazo' => 12,
            'descripcion' => 'Préstamo personal con 5% de interés',
        ]);

        $tipoPrestamo2 = TipoPrestamo::create([
            'nombre' => 'Préstamo Empresarial',
            'interes' => 8,
            'plazo' => 24,
            'descripcion' => 'Préstamo para empresas con 8% de interés',
        ]);

        $tipoPrestamo3 = TipoPrestamo::create([
            'nombre' => 'Préstamo Educativo',
            'interes' => 3,
            'plazo' => 36,
            'descripcion' => 'Préstamo educativo con 3% de interés',
        ]);

        // Crear clientes
        $cliente1 = Cliente::create([
            'nombre' => 'Juan',
            'apellido' => 'Pérez',
            'ci' => '12345678',
            'email' => 'juan@example.com',
            'telefono' => '555-1234',
            'direccion' => 'Calle Principal 123',
        ]);

        $cliente2 = Cliente::create([
            'nombre' => 'María',
            'apellido' => 'González',
            'ci' => '87654321',
            'email' => 'maria@example.com',
            'telefono' => '555-5678',
            'direccion' => 'Avenida Secundaria 456',
        ]);

        $cliente3 = Cliente::create([
            'nombre' => 'Carlos',
            'apellido' => 'López',
            'ci' => '11223344',
            'email' => 'carlos@example.com',
            'telefono' => '555-9999',
            'direccion' => 'Calle Terciaria 789',
        ]);

        // Crear préstamo 1: Cliente 1 - Préstamo Personal
        $prestamo1 = Prestamo::create([
            'cliente_id' => $cliente1->id,
            'tipo_prestamo_id' => $tipoPrestamo1->id,
            'monto' => 10000,
            'fecha' => now()->subMonths(6)->toDateString(),
            'estado' => 'activo',
        ]);
        $prestamoService->generarCuotas($prestamo1);

        // Agregar algunos pagos al primer préstamo
        $cuotas1 = $prestamo1->cuotas;
        $pago1 = Pago::create([
            'cuota_id' => $cuotas1[0]->id,
            'fecha' => now()->subMonths(5)->toDateString(),
            'monto' => $cuotas1[0]->monto,
            'metodo' => 'transferencia',
        ]);
        $prestamoService->procesarPago($cuotas1[0], $pago1->monto);

        $pago2 = Pago::create([
            'cuota_id' => $cuotas1[1]->id,
            'fecha' => now()->subMonths(4)->toDateString(),
            'monto' => $cuotas1[1]->monto,
            'metodo' => 'efectivo',
        ]);
        $prestamoService->procesarPago($cuotas1[1], $pago2->monto);

        // Crear préstamo 2: Cliente 2 - Préstamo Empresarial
        $prestamo2 = Prestamo::create([
            'cliente_id' => $cliente2->id,
            'tipo_prestamo_id' => $tipoPrestamo2->id,
            'monto' => 50000,
            'fecha' => now()->subMonths(3)->toDateString(),
            'estado' => 'activo',
        ]);
        $prestamoService->generarCuotas($prestamo2);

        // Crear préstamo 3: Cliente 3 - Préstamo Educativo
        $prestamo3 = Prestamo::create([
            'cliente_id' => $cliente3->id,
            'tipo_prestamo_id' => $tipoPrestamo3->id,
            'monto' => 25000,
            'fecha' => now()->toDateString(),
            'estado' => 'activo',
        ]);
        $prestamoService->generarCuotas($prestamo3);
    }
}
