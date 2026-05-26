<?php

namespace App\Http\Controllers;

use App\Models\Cliente;
use App\Models\Cuota;
use App\Models\Pago;
use App\Models\Prestamo;
use Illuminate\View\View;

class DashboardController extends Controller
{
    public function index(): View
    {
        $totalClientes = Cliente::count();
        $prestamosActivos = Prestamo::where('estado', 'activo')->count();
        $prestamosCompletados = Prestamo::where('estado', 'completado')->count();
        $cuotasPendientes = Cuota::where('estado', 'pendiente')->count();
        $montoTotalAdeudado = Cuota::sum('saldo');

        // Nuevas métricas
        $montoTotalPrestado = Prestamo::sum('monto');
        $montoTotalRecaudado = Pago::sum('monto');
        $cuotasVencidas = Cuota::where('estado', '!=', 'pagada')
            ->where('vencimiento', '<', now())
            ->count();

        $prestamosRecientes = Prestamo::with('cliente')
            ->latest()
            ->limit(5)
            ->get();

        $pagosRecientes = Pago::with('cuota.prestamo.cliente')
            ->latest()
            ->limit(5)
            ->get();

        // Datos para gráfico (últimos 7 días)
        $pagosPorDia = Pago::selectRaw('DATE(fecha) as fecha, SUM(monto) as total')
            ->where('fecha', '>=', now()->subDays(7))
            ->groupBy('fecha')
            ->orderBy('fecha')
            ->get();

        return view('dashboard', compact(
            'totalClientes',
            'prestamosActivos',
            'prestamosCompletados',
            'cuotasPendientes',
            'montoTotalAdeudado',
            'montoTotalPrestado',
            'montoTotalRecaudado',
            'cuotasVencidas',
            'prestamosRecientes',
            'pagosRecientes',
            'pagosPorDia'
        ));
    }
}
