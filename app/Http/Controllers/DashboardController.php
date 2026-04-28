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
        $cuotasPendientes = Cuota::where('estado', 'pendiente')->count();
        $montoTotalAdeudado = Cuota::sum('saldo');

        $prestamosRecientes = Prestamo::with('cliente')
            ->latest()
            ->limit(5)
            ->get();

        $pagosRecientes = Pago::with('cuota.prestamo.cliente')
            ->latest()
            ->limit(5)
            ->get();

        return view('dashboard', compact(
            'totalClientes',
            'prestamosActivos',
            'cuotasPendientes',
            'montoTotalAdeudado',
            'prestamosRecientes',
            'pagosRecientes'
        ));
    }
}
