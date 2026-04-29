<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css" rel="stylesheet">
    <link href="{{ asset('/css/app.css') }}" rel="stylesheet" />

    <title>@yield('title', 'Panel de Admin - Elite Sport')</title>
</head>

<body>
    <div class="d-flex flex-column min-vh-100">
        <!-- Admin Navbar -->
        <nav class="navbar navbar-expand-lg navbar-dark admin-navbar sticky-top">
            <div class="container-fluid">
                <a class="navbar-brand fw-bold" href="{{ route('product.index') }}">
                    <i class="bi bi-speedometer2"></i> Panel de Administración
                </a>

                <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#adminNavbar"
                    aria-controls="adminNavbar" aria-expanded="false" aria-label="Toggle navigation">
                    <span class="navbar-toggler-icon"></span>
                </button>

                <div class="collapse navbar-collapse" id="adminNavbar">
                    <ul class="navbar-nav ms-auto">
                        <li class="nav-item dropdown">
                            <button class="btn btn-link nav-link dropdown-toggle text-white" type="button"
                                data-bs-toggle="dropdown" aria-expanded="false">
                                <i class="bi bi-person-circle"></i> {{ Auth::user()->getName() }}
                            </button>
                            <ul class="dropdown-menu dropdown-menu-end">
                                <li>
                                    <form id="logout" action="{{ route('logout') }}" method="POST">
                                        @csrf
                                        <button type="submit" class="dropdown-item logout-item">
                                            <i class="bi bi-box-arrow-right"></i> Cerrar sesión
                                        </button>
                                    </form>
                                </li>
                            </ul>
                        </li>
                    </ul>
                </div>
            </div>
        </nav>

        <!-- Main Layout with Sidebar -->
        <div class="d-flex flex-grow-1">
            <!-- Sidebar -->
            <nav class="admin-sidebar d-md-block" style="width: 250px;">
                <ul class="sidebar-nav">
                    <li class="nav-item">
                        <strong
                            style="color: rgba(255,255,255,0.5); padding: 0.75rem 1.5rem; display: block; font-size: 0.85rem; text-transform: uppercase;">
                            Gestión
                        </strong>
                    </li>
                    <li class="nav-item">
                        <a href="{{ route('product.index') }}"
                            class="nav-link {{ request()->routeIs('product.*') ? 'active' : '' }}">
                            <i class="bi bi-box-seam"></i> Productos
                        </a>
                    </li>
                    <li class="nav-item">
                        <a href="{{ route('user.index') }}"
                            class="nav-link {{ request()->routeIs('user.*') ? 'active' : '' }}">
                            <i class="bi bi-people"></i> Usuarios
                        </a>
                    </li>
                    <li class="nav-item">
                        <hr style="margin: 0.5rem 0; border-color: rgba(255,255,255,0.1);">
                    </li>
                    <li class="nav-item">
                        <strong
                            style="color: rgba(255,255,255,0.5); padding: 0.75rem 1.5rem; display: block; font-size: 0.85rem; text-transform: uppercase;">
                            Acciones Rápidas
                        </strong>
                    </li>
                    <li class="nav-item">
                        <a href="{{ route('product.create') }}" class="nav-link">
                            <i class="bi bi-plus-circle"></i> Crear Producto
                        </a>
                    </li>
                    <li class="nav-item">
                        <a href="{{ route('user.create') }}" class="nav-link">
                            <i class="bi bi-person-plus"></i> Crear Usuario
                        </a>
                    </li>
                    <li class="nav-item">
                        <a href="{{ route('category.create') }}" class="nav-link">
                            <i class="bi bi-tags"></i> Crear Categoría
                        </a>
                    </li>
                </ul>
            </nav>

            <!-- Main Content -->
            <main class="admin-main flex-grow-1">
                @yield('content')
            </main>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
    <script src="{{ asset('/js/app.js') }}"></script>
</body>

</html>