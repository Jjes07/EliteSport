<!DOCTYPE html>
<html lang="{{ app()->getLocale() }}">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css" rel="stylesheet">
    <link href="{{ asset('/css/app.css') }}" rel="stylesheet" />

    <title>@yield('title', 'Panel de Administración - Elite Sport')</title>
</head>

<body>
    <div class="d-flex flex-column min-vh-100">
        <!-- Admin Navbar -->
        <nav class="navbar navbar-expand-lg navbar-dark admin-navbar sticky-top">
            <div class="container-fluid">
                <a class="navbar-brand fw-bold" href="{{ route('admin.product.index') }}">
                    <i class="bi bi-speedometer2 ms-2 me-3"></i> {{ __('admin.admin_panel') }}
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
                                <i class="bi bi-globe"></i> {{ __('navigation.language') }}
                            </button>
                            <ul class="dropdown-menu dropdown-menu-end">
                                <li>
                                    <a class="dropdown-item {{ app()->getLocale() == 'es' ? 'active' : '' }}"
                                    href="{{ route('lang.switch', 'es') }}">
                                        {{ __('navigation.spanish') }}
                                    </a>
                                </li>
                                <li>
                                    <a class="dropdown-item {{ app()->getLocale() == 'en' ? 'active' : '' }}"
                                    href="{{ route('lang.switch', 'en') }}">
                                        {{ __('navigation.english') }}
                                    </a>
                                </li>
                            </ul>
                        </li>
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
                                            <i class="bi bi-box-arrow-right"></i> {{ __('navigation.logout') }}
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
                <div class="sidebar-logo">
                    <a href="{{ route('admin.product.index') }}">
                        <img src="{{ asset('/images/logo.png') }}" alt="Elite Sport Logo">
                    </a>
                </div>
                <ul class="sidebar-nav">
                    <li class="nav-item">
                        <strong
                            style="color: rgba(255,255,255,0.5); padding: 0.75rem 1.5rem; display: block; font-size: 0.85rem; text-transform: uppercase;">
                            {{ __('admin.management') }}
                        </strong>
                    </li>
                    <li class="nav-item">
                        <a href="{{ route('admin.product.index') }}"
                            class="nav-link {{ request()->routeIs('admin.product.*') ? 'active' : '' }}">
                            <i class="bi bi-box-seam"></i> {{ __('admin.products') }}
                        </a>
                    </li>
                    <li class="nav-item">
                        <a href="{{ route('user.index') }}"
                            class="nav-link {{ request()->routeIs('user.*') ? 'active' : '' }}">
                            <i class="bi bi-people"></i> {{ __('admin.users') }}
                        </a>
                    </li>
                    <li class="nav-item">
                        <hr style="margin: 0.5rem 0; border-color: rgba(255,255,255,0.1);">
                    </li>
                    <li class="nav-item">
                        <strong
                            style="color: rgba(255,255,255,0.5); padding: 0.75rem 1.5rem; display: block; font-size: 0.85rem; text-transform: uppercase;">
                            {{ __('admin.fast_actions') }}
                        </strong>
                    </li>
                    <li class="nav-item">
                        <a href="{{ route('admin.product.create') }}" class="nav-link">
                            <i class="bi bi-plus-circle"></i> {{ __('admin.create_product') }}
                        </a>
                    </li>
                    <li class="nav-item">
                        <a href="{{ route('user.create') }}" class="nav-link">
                            <i class="bi bi-person-plus"></i> {{ __('admin.create_user') }}
                        </a>
                    </li>
                    <li class="nav-item">
                        <a href="{{ route('category.create') }}" class="nav-link">
                            <i class="bi bi-tags"></i> {{ __('admin.create_category') }}
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