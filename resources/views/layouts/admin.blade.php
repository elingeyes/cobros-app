<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>@yield('title', 'Cobros App') - Sistema de Gestión de Préstamos</title>

    <!-- AdminLTE CSS -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/admin-lte/3.2.0/adminlte.min.css">
    <!-- Bootstrap Icons -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-icons/1.11.1/font/bootstrap-icons.min.css">
    <!-- DataTables CSS -->
    <link rel="stylesheet" href="https://cdn.datatables.net/1.13.7/css/dataTables.bootstrap5.min.css">
    <!-- Select2 CSS -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css">
    <!-- Custom CSS -->
    <style>
        .sidebar-nav .nav-link.active {
            background-color: #007bff;
            color: #fff;
        }
        .btn-sm {
            padding: 0.25rem 0.5rem;
            font-size: 0.875rem;
        }
    </style>
    @yield('styles')
</head>
<body class="hold-transition sidebar-mini dark-mode">
    <div class="wrapper">
        <!-- Header -->
        <nav class="main-header navbar navbar-expand navbar-dark navbar-lightblue">
            <ul class="navbar-nav">
                <li class="nav-item">
                    <a class="nav-link" data-widget="pushmenu" href="#" role="button">
                        <i class="fas fa-bars"></i>
                    </a>
                </li>
            </ul>

            <ul class="navbar-nav ml-auto">
                <li class="nav-item dropdown">
                    <a class="nav-link dropdown-toggle" href="#" id="userDropdown" role="button" data-bs-toggle="dropdown">
                        <i class="fas fa-user-circle"></i> {{ Auth::user()->name ?? 'Usuario' }}
                    </a>
                    <ul class="dropdown-menu dropdown-menu-end">
                        <li><a class="dropdown-item" href="{{ route('logout') }}" onclick="event.preventDefault(); document.getElementById('logout-form').submit();">Cerrar Sesión</a></li>
                    </ul>
                    <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
                        @csrf
                    </form>
                </li>
            </ul>
        </nav>

        <!-- Sidebar -->
        <aside class="main-sidebar sidebar-dark-primary elevation-4">
            <a href="{{ route('dashboard') }}" class="brand-link">
                <img src="https://via.placeholder.com/33x33?text=CA" alt="Logo" class="brand-image img-circle elevation-3">
                <span class="brand-text font-weight-light">Cobros App</span>
            </a>

            <div class="sidebar">
                <nav class="mt-2">
                    <ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview" role="menu">
                        <li class="nav-item">
                            <a href="{{ route('dashboard') }}" class="nav-link {{ request()->routeIs('dashboard') ? 'active' : '' }}">
                                <i class="nav-icon fas fa-home"></i>
                                <p>Dashboard</p>
                            </a>
                        </li>

                        <li class="nav-header">GESTIÓN</li>

                        <li class="nav-item">
                            <a href="{{ route('clientes.index') }}" class="nav-link {{ request()->routeIs('clientes.*') ? 'active' : '' }}">
                                <i class="nav-icon fas fa-users"></i>
                                <p>Clientes</p>
                            </a>
                        </li>

                        <li class="nav-item">
                            <a href="{{ route('tipos-prestamo.index') }}" class="nav-link {{ request()->routeIs('tipos-prestamo.*') ? 'active' : '' }}">
                                <i class="nav-icon fas fa-list"></i>
                                <p>Tipos de Préstamo</p>
                            </a>
                        </li>

                        <li class="nav-item">
                            <a href="{{ route('prestamos.index') }}" class="nav-link {{ request()->routeIs('prestamos.*') ? 'active' : '' }}">
                                <i class="nav-icon fas fa-money-bill"></i>
                                <p>Préstamos</p>
                            </a>
                        </li>

                        <li class="nav-item">
                            <a href="{{ route('cuotas.index') }}" class="nav-link {{ request()->routeIs('cuotas.*') ? 'active' : '' }}">
                                <i class="nav-icon fas fa-calendar-check"></i>
                                <p>Cuotas</p>
                            </a>
                        </li>

                        <li class="nav-item">
                            <a href="{{ route('pagos.index') }}" class="nav-link {{ request()->routeIs('pagos.*') ? 'active' : '' }}">
                                <i class="nav-icon fas fa-credit-card"></i>
                                <p>Pagos</p>
                            </a>
                        </li>
                    </ul>
                </nav>
            </div>
        </aside>

        <!-- Content Wrapper -->
        <div class="content-wrapper">
            <!-- Content Header -->
            <div class="content-header">
                <div class="container-fluid">
                    @yield('header-title')
                </div>
            </div>

            <!-- Main Content -->
            <div class="content">
                <div class="container-fluid">
                    @if (session('success'))
                        <div class="alert alert-success alert-dismissible fade show" role="alert">
                            <i class="fas fa-check-circle"></i> {{ session('success') }}
                            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                        </div>
                    @endif

                    @if (session('error'))
                        <div class="alert alert-danger alert-dismissible fade show" role="alert">
                            <i class="fas fa-exclamation-circle"></i> {{ session('error') }}
                            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                        </div>
                    @endif

                    @if ($errors->any())
                        <div class="alert alert-danger alert-dismissible fade show" role="alert">
                            <i class="fas fa-exclamation-triangle"></i> <strong>Errores de validación:</strong>
                            <ul class="mt-2 mb-0">
                                @foreach ($errors->all() as $error)
                                    <li>{{ $error }}</li>
                                @endforeach
                            </ul>
                            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                        </div>
                    @endif

                    @yield('content')
                </div>
            </div>
        </div>

        <!-- Footer -->
        <footer class="main-footer">
            <strong>Cobros App</strong> - Sistema de Gestión de Préstamos &copy; 2026. Todos los derechos reservados.
        </footer>
    </div>

    <!-- Scripts -->
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/admin-lte/3.2.0/adminlte.min.js"></script>
    <script src="https://cdn.datatables.net/1.13.7/js/jquery.dataTables.min.js"></script>
    <script src="https://cdn.datatables.net/1.13.7/js/dataTables.bootstrap5.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>

    <script>
        $(document).ready(function () {
            $('.table').DataTable({
                language: {
                    url: 'https://cdn.datatables.net/plug-ins/1.13.7/i18n/es-ES.json'
                },
                responsive: true,
                autoWidth: false
            });

            $('.select2').select2();
        });
    </script>

    @yield('scripts')
</body>
</html>
