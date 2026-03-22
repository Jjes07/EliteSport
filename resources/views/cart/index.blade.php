@extends('layouts.app')

@section('title', $viewData["title"])
@section('subtitle', $viewData["subtitle"])

@section('content')
    <div class="container my-4">
        <div class="card shadow-sm border-0">
            <div class="card-header bg-dark text-white">
                <h4 class="mb-0">Productos en el carrito</h4>
            </div>

            <div class="card-body">
                @if(session('success'))
                    <div class="alert alert-success">
                        {{ session('success') }}
                    </div>
                @endif

                @if(count($viewData["products"]) > 0)
                    <div class="table-responsive">
                        <table class="table table-hover align-middle text-center">
                            <thead class="table-light">
                                <tr>
                                    <th scope="col">ID</th>
                                    <th scope="col">Nombre</th>
                                    <th scope="col">Precio</th>
                                    <th scope="col">Cantidad</th>
                                    <th scope="col">Subtotal</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($viewData["products"] as $product)
                                    <tr>
                                        <td>{{ $product->getId() }}</td>
                                        <td class="fw-semibold">{{ $product->getName() }}</td>
                                        <td>${{ number_format($product->getPrice(), 0, ',', '.') }}</td>
                                        <td>
                                            <span class="badge bg-secondary">
                                                {{ session('products')[$product->getId()] }}
                                            </span>
                                        </td>
                                        <td>
                                            ${{ number_format($product->getPrice() * session('products')[$product->getId()], 0, ',', '.') }}
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>

                    <div class="d-flex justify-content-between align-items-center flex-wrap gap-3 mt-4">
                        <div>
                            <a href="{{ route('home.index') }}" class="btn btn-outline-secondary">
                                Seguir comprando
                            </a>
                        </div>

                        <div class="d-flex align-items-center gap-2 flex-wrap">
                            <div class="px-3 py-2 border rounded bg-light">
                                <strong>Total a pagar:</strong>
                                ${{ number_format($viewData["total"], 0, ',', '.') }}
                            </div>

                            <a href="#" class="btn btn-primary">
                                Comprar
                            </a>

                            <a href="{{ route('cart.delete') }}" class="btn btn-danger">
                                Vaciar carrito
                            </a>
                        </div>
                    </div>
                @else
                    <div class="text-center py-5">
                        <h5 class="mb-3">Tu carrito está vacío</h5>
                        <p class="text-muted">Aún no has agregado productos.</p>
                        <a href="{{ route('home.index') }}" class="btn btn-primary">
                            Ir a comprar
                        </a>
                    </div>
                @endif
            </div>
        </div>
    </div>
@endsection