<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css" rel="stylesheet">
    <link href="{{ asset('/css/app.css') }}" rel="stylesheet" />
    
    <title>@yield('title', 'Elite Sport')</title>
</head>

<body class="d-flex flex-column min-vh-100">
    <nav class="navbar navbar-expand-lg navbar-dark sticky-top">
        <div class="container">
            <a class="navbar-brand" href="{{ route('home.index') }}">
                <img src="{{ asset('/images/logo.png') }}" alt="Elite Sport Logo">
            </a>

            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNavAltMarkup"
                aria-controls="navbarNavAltMarkup" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>

            <div class="collapse navbar-collapse" id="navbarNavAltMarkup">
                <div class="navbar-nav ms-auto align-items-center gap-2">
                    @auth
                        @if(Auth::user()->getRole() == 'admin')
                            <a class="nav-link" href="{{ route('product.create') }}">
                                <i class="bi bi-plus-circle"></i> {{ __('navigation.new_product') }}
                            </a>
                            <a class="nav-link" href="{{ route('product.index') }}">
                                <i class="bi bi-box"></i> {{ __('navigation.products') }}
                            </a>
                            <a class="nav-link" href="{{ route('user.create') }}">
                                <i class="bi bi-person-plus"></i> {{ __('navigation.create_user') }}
                            </a>
                            <a class="nav-link" href="{{ route('user.index') }}">
                                <i class="bi bi-people"></i> {{ __('navigation.users') }}
                            </a>
                        @endif

                        <a class="nav-link" href="{{ route('cart.index') }}">
                            <i class="bi bi-cart"></i> {{ __('navigation.cart') }}
                        </a>
                        
                        <div class="vr d-none d-lg-block"></div>
                        
                        <div class="dropdown">
                            <button class="btn btn-link nav-link dropdown-toggle" type="button" data-bs-toggle="dropdown">
                                <i class="bi bi-person-circle"></i> {{ Auth::user()->getName() }}
                            </button>
                            <ul class="dropdown-menu dropdown-menu-end">
                                <li>
                                    <form id="logout" action="{{ route('logout') }}" method="POST">
                                        @csrf
                                        <button type="submit" class="dropdown-item">
                                            <i class="bi bi-box-arrow-right"></i> {{ __('navigation.logout') }}
                                        </button>
                                    </form>
                                </li>
                            </ul>
                        </div>
                    @else
                        <a class="nav-link" href="{{ route('login') }}">
                            <i class="bi bi-box-arrow-in-right"></i> {{ __('navigation.login') }}
                        </a>
                        <a class="nav-link btn btn-outline-light px-3" href="{{ route('register') }}">
                            <i class="bi bi-person-plus"></i> {{ __('navigation.register') }}
                        </a>
                    @endauth
                </div>
            </div>
        </div>
    </nav>

    <main class="flex-grow-1">
        @yield('content')
    </main>

    <footer class="footer mt-auto">
        <div class="container">
            <div class="row">
                <div class="col-md-4">
                    <img src="{{ asset('/images/logo.png') }}" alt="Elite Sport">
                </div>
                <div class="col-md-4">
                    <p class="mb-0 small">© 2026 EliteSport.</p>
                </div>
                <div class="col-md-4">
                    <div class="footer-social">
                        <a href="#" aria-label="Facebook"><i class="bi bi-facebook"></i></a>
                        <a href="#" aria-label="Instagram"><i class="bi bi-instagram"></i></a>
                        <a href="#" aria-label="Twitter"><i class="bi bi-twitter-x"></i></a>
                    </div>
                </div>
            </div>
        </div>
    </footer>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
    <script src="{{ asset('/js/app.js') }}"></script>
</body>

</html>