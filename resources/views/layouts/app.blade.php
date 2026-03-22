<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="{{ asset('/css/app.css') }}" rel="stylesheet" />
    <title>@yield('title', 'Online store')</title>
</head>

<body class="d-flex flex-column min-vh-100 bg-light">
    <nav class="navbar navbar-expand-lg navbar-dark bg-header py-3">
        <div class="container-fluid">
            <a class="navbar-brand" href="{{ route('home.index') }}">
                <img src="{{ asset('/images/logo.png') }}" alt="Sport Store Logo" style="height: 120px;">
            </a>

            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNavAltMarkup"
                aria-controls="navbarNavAltMarkup" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>

            <div class="collapse navbar-collapse" id="navbarNavAltMarkup">
                <div class="navbar-nav ms-auto">
                    @auth

                        @if(Auth::user()->getRole() == 'admin')
                            <a class="nav-link active" href="{{ route('product.create') }}">
                                <b>{{ __('navigation.new_product') }}</b>
                            </a>

                            <a class="nav-link active" href="{{ route('product.index') }}">
                                <b>{{ __('navigation.products') }}</b>
                            </a>

                            <a class="nav-link active" href="{{ route('user.create') }}">
                                <b>{{ __('navigation.create_user') }}</b>
                            </a>

                            <a class="nav-link active" href="{{ route('user.index') }}">
                                <b>{{ __('navigation.users') }}</b>
                            </a>

                        @endif

                        @if(Auth::user()->getRole() == 'customer')
                            <a class="nav-link active" href="{{ route('cart.index') }}">
                                <b>{{ __('navigation.cart') }}</b>
                            </a>
                        @endif
                    @endauth

                    <div class="vr bg-white mx-2 d-none d-lg-block"></div>

                    @guest
                        <a class="nav-link active" href="{{ route('login') }}">{{ __('navigation.login') }}</a>
                        <a class="nav-link active" href="{{ route('register') }}">{{ __('navigation.register') }}</a>
                    @else
                        <form id="logout" action="{{ route('logout') }}" method="POST" class="d-inline">
                            @csrf
                            <a role="button" class="nav-link active"
                                onclick="event.preventDefault(); document.getElementById('logout').submit();">
                                {{ __('navigation.logout') }}
                            </a>
                        </form>
                    @endguest
                </div>
            </div>
        </div>
    </nav>

    <div>
        @yield('content')
    </div>

    <footer class="bg-blue text-white text-center py-4 mt-auto">
    </footer>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
</body>

</html>