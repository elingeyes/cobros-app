<?php

namespace App\Services;

use App\Models\Cuota;
use App\Models\Prestamo;
use Carbon\Carbon;

class PrestamoService
{
    /**
     * Generar automáticamente las cuotas de un préstamo
     */
    public function generarCuotas(Prestamo $prestamo): void
    {
        $tipoPrestamo = $prestamo->tipoPrestamo;
        $monto = $prestamo->monto;
        $interes = $tipoPrestamo->interes;
        $plazo = $tipoPrestamo->plazo;

        $montoCuota = $this->calcularMontoCuota($monto, $interes, $plazo);
        $fechaInicio = Carbon::parse($prestamo->fecha);

        for ($i = 1; $i <= $plazo; $i++) {
            $vencimiento = $fechaInicio->copy()->addMonths($i);

            Cuota::create([
                'prestamo_id' => $prestamo->id,
                'numero' => $i,
                'vencimiento' => $vencimiento,
                'monto' => $montoCuota,
                'saldo' => $montoCuota,
                'estado' => 'pendiente',
            ]);
        }
    }

    /**
     * Calcular el monto de cada cuota
     */
    public function calcularMontoCuota(float|string $monto, float|string $interes, int $plazo): float
    {
        $monto = (float) $monto;
        $interes = (float) $interes;
        $montoInteres = $monto * ($interes / 100);
        $montoTotal = $monto + $montoInteres;

        return round($montoTotal / $plazo, 2);
    }

    /**
     * Procesar pago en una cuota
     */
    public function procesarPago(Cuota $cuota, float|string $monto): void
    {
        $monto = (float) $monto;
        $nuevoSaldo = $cuota->saldo - $monto;

        if ($nuevoSaldo <= 0) {
            $cuota->update([
                'saldo' => 0,
                'estado' => 'pagada',
            ]);
            $this->actualizarEstadoPrestamo($cuota->prestamo);
        } else {
            $cuota->update([
                'saldo' => $nuevoSaldo,
                'estado' => 'parcial',
            ]);
        }
    }

    /**
     * Actualizar estado del préstamo según sus cuotas
     */
    public function actualizarEstadoPrestamo(Prestamo $prestamo): void
    {
        $cuotas = $prestamo->cuotas;
        $totalCuotas = $cuotas->count();
        $cuotasPagadas = $cuotas->whereIn('estado', ['pagada'])->count();

        if ($totalCuotas === $cuotasPagadas) {
            $prestamo->update(['estado' => 'completado']);
        }
    }
}
