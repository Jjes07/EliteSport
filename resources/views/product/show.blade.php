@extends('layouts.app')

@section('title', $viewData['title'])

@section('content')
    <div class="container my-4">
        <div class="card shadow-sm border-0">
            <div class="card-header bg-dark text-white">
                <h4 class="mb-0">Detalle del Producto</h4>
            </div>

            <div class="card-body p-4">
                @if(session('success'))
                    <div class="alert alert-success">
                        {{ session('success') }}
                    </div>
                @endif

                <div class="row align-items-center g-4">
                    <div class="col-md-4 text-center">
                        <img src="{{ $viewData['product']->getImage() }}" class="img-fluid rounded product-detail-image"
                            alt="{{ $viewData['product']->getName() }}">
                    </div>

                    <div class="col-md-8">
                        <h2 class="fw-bold mb-3">
                            {{ $viewData['product']->getName() }}
                        </h2>

                        <p class="mb-2">
                            <strong>ID:</strong> {{ $viewData['product']->getId() }}
                        </p>

                        <p class="mb-2">
                            <strong>Descripción:</strong> {{ $viewData['product']->getDescription() }}
                        </p>

                        <p class="mb-2 fs-4 fw-bold text-primary">
                            ${{ number_format($viewData['product']->getPrice(), 0, ',', '.') }}
                        </p>

                        <p class="mb-4">
                            <strong>Stock:</strong>
                            @if($viewData['product']->getStock() > 0)
                                <span class="badge bg-success">
                                    Disponible ({{ $viewData['product']->getStock() }})
                                </span>
                            @else
                                <span class="badge bg-danger">
                                    Agotado
                                </span>
                            @endif
                        </p>

                        @if($viewData['product']->getStock() > 0)
                            <form method="POST" action="{{ route('cart.add', ['id' => $viewData['product']->getId()]) }}">
                                @csrf

                                <div class="d-flex flex-wrap align-items-end gap-3">
                                    <div>
                                        <label for="quantity" class="form-label fw-semibold">Cantidad</label>
                                        <input id="quantity" type="number" min="1" max="{{ $viewData['product']->getStock() }}"
                                            class="form-control" name="quantity" value="1" style="width: 120px;">
                                    </div>

                                    <div>
                                        <button class="btn btn-primary px-4" type="submit">
                                            Agregar al carrito
                                        </button>
                                    </div>

                                    <div>
                                        <a href="{{ route('home.index') }}" class="btn btn-outline-secondary">
                                            Volver al inicio
                                        </a>
                                    </div>
                                </div>
                            </form>
                        @else
                            <div class="d-flex flex-wrap gap-2">
                                <button class="btn btn-secondary" disabled>
                                    Producto agotado
                                </button>

                                <a href="{{ route('home.index') }}" class="btn btn-outline-secondary">
                                    Volver al inicio
                                </a>
                            </div>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection